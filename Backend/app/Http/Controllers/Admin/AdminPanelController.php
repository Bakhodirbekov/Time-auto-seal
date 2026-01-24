<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminPanelController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_cars' => Car::count(),
            'active_timers' => Car::timerActive()->count(),
            'today_listed' => Car::whereDate('created_at', today())->count(),
            'hot_deals' => Car::hotDeals()->count(),
            'total_users' => User::where('role', 'user')->count(),
        ];

        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $activeCategories = Category::withCount('cars')
            ->orderBy('cars_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'activeCategories'));
    }

    public function cars(Request $request)
    {
        $query = Car::with(['user', 'category', 'subcategory']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.cars', compact('cars'));
    }

    public function categories()
    {
        $categories = Category::with('subcategories')->withCount('cars')->orderBy('order')->get();
        return view('admin.categories', compact('categories'));
    }

    public function users(Request $request)
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.users', compact('users'));
    }

    public function complaints()
    {
        $complaints = Complaint::with(['user', 'car'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.complaints', compact('complaints'));
    }

    public function settings()
    {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }
    
    public function hotDeals()
    {
        $cars = Car::hotDeals()->with(['category', 'images'])->paginate(10);
        return view('admin.hot_deals', compact('cars'));
    }

    public function carsCreate()
    {
        $categories = Category::active()->get();
        return view('admin.create_car', compact('categories'));
    }

    public function carsStore(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer',
                'contact_phone' => 'nullable|string|max:20',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $car = Car::create([
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'fuel_type' => $request->fuel_type,
                'transmission' => $request->transmission,
                'condition' => $request->condition,
                'mileage' => $request->mileage,
                'contact_phone' => $request->contact_phone,
                'status' => 'approved',
                'price_visible' => false,
            ]);

            $car->startTimer();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('cars', 'public');
                    $car->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                        'order' => $index,
                    ]);
                }
            }

            return redirect()->route('admin.cars')->with('success', 'Avtomobil muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            Log::error('Car creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function carsEdit($id)
    {
        $car = Car::with('images')->findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.edit_car', compact('car', 'categories'));
    }

    public function carsUpdate(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'contact_phone' => 'nullable|string|max:20',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = Car::findOrFail($id);
        $car->update($request->except('images'));

        // Yangi rasmlarni qo'shish
        if ($request->hasFile('images')) {
            $existingCount = $car->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'is_primary' => ($existingCount === 0 && $index === 0),
                    'order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('admin.cars')->with('success', 'Avtomobil yangilandi.');
    }

    public function carsDestroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return redirect()->route('admin.cars')->with('success', 'Avtomobil o\'chirildi.');
    }

    public function carsApprove($id)
    {
        $car = Car::findOrFail($id);
        $car->status = 'approved';
        $car->startTimer();
        $car->save();
        return back()->with('success', 'Avtomobil tasdiqlandi va taymer boshlandi.');
    }

    public function toggleHotDeal($id)
    {
        $car = Car::findOrFail($id);
        $car->is_hot_deal = !$car->is_hot_deal;
        $car->save();
        return back()->with('success', 'Holati o\'zgartirildi.');
    }

    public function categoriesStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => true,
        ]);
        return back()->with('success', 'Kategoriya qo\'shildi.');
    }

    public function categoriesEdit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::with('subcategories')->withCount('cars')->orderBy('order')->get();
        return view('admin.categories', compact('categories', 'category'));
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->boolean('is_active'),
        ]);
        return back()->with('success', 'Kategoriya yangilandi.');
    }

    public function categoriesDestroy($id)
    {
        Category::destroy($id);
        return back()->with('success', 'Kategoriya o\'chirildi.');
    }

    public function usersBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();
        return back()->with('success', 'Foydalanuvchi bloklandi.');
    }

    public function usersUnblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();
        return back()->with('success', 'Foydalanuvchi blokdan chiqarildi.');
    }

    public function complaintsResolve($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'resolved';
        $complaint->save();
        return back()->with('success', 'Shikoyat yopildi.');
    }

    public function timersExpire($id)
    {
        $car = Car::findOrFail($id);
        $car->expireTimer();
        return back()->with('success', 'Taymer vaqtidan oldin tugatildi.');
    }

    public function settingsUpdate(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        return back()->with('success', 'Sozlamalar saqlandi.');
    }

    public function timers()
    {
        $cars = Car::timerActive()->with('user')->orderBy('timer_end_at')->paginate(10);
        return view('admin.timers', compact('cars'));
    }

    public function notifications()
    {
        $notifications = Notification::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notifications', compact('notifications'));
    }

    public function admins()
    {
        $user = auth()->user();
        $query = User::whereIn('role', ['admin', 'moderator', 'superadmin'])->orderBy('name');

        if ($user->role === 'admin') {
            // Admin faqat moderatorlarni ko'radi
            $query->where('role', 'moderator');
        }
        // Superadmin hamma admin va moderatorlarni ko'radi

        $admins = $query->get();
        return view('admin.admins', compact('admins'));
    }

    public function adminsCreate()
    {
        return view('admin.create_admin');
    }

    public function adminsStore(Request $request)
    {
        $user = auth()->user();
        
        $allowedRoles = ['moderator'];
        if ($user->role === 'superadmin') {
            $allowedRoles[] = 'admin';
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Xodim muvaffaqiyatli qo\'shildi.');
    }

    public function adminsEdit($id)
    {
        $currentUser = auth()->user();
        $admin = User::findOrFail($id);

        // Xavfsizlik tekshiruvi
        if ($currentUser->role === 'admin' && $admin->role !== 'moderator') {
            return redirect()->route('admin.admins.index')->with('error', 'Siz faqat moderatorlarni tahrirlashingiz mumkin.');
        }

        return view('admin.edit_admin', compact('admin'));
    }

    public function adminsUpdate(Request $request, $id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        // Xavfsizlik tekshiruvi
        if ($currentUser->role === 'admin' && $user->role !== 'moderator') {
            return redirect()->route('admin.admins.index')->with('error', 'Siz faqat moderatorlarni tahrirlashingiz mumkin.');
        }

        $allowedRoles = ['moderator'];
        if ($currentUser->role === 'superadmin') {
            $allowedRoles[] = 'admin';
            $allowedRoles[] = 'superadmin';
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Ma\'lumotlar yangilandi.');
    }

    public function adminsDestroy($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);
        
        if ($user->id === $currentUser->id) {
            return back()->with('error', 'O\'zingizni o\'chira olmaysiz.');
        }

        if ($currentUser->role === 'admin' && $user->role !== 'moderator') {
            return back()->with('error', 'Siz faqat moderatorlarni o\'chirishingiz mumkin.');
        }

        $user->delete();
        return back()->with('success', 'Xodim o\'chirildi.');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profilingiz yangilandi.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->role === 'admin' || $user->role === 'moderator') {
                return redirect()->intended(route('admin.dashboard'));
            }
            auth()->logout();
            return back()->withErrors(['email' => 'Sizda admin panelga kirish huquqi yo\'q.']);
        }

        return back()->withErrors(['email' => 'Email yoki parol xato.']);
    }

    public function deleteCarImage($id)
    {
        $image = CarImage::findOrFail($id);
        $carId = $image->car_id;
        
        // Rasmni storage dan o'chirish
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Agar bu primary rasm bo'lsa va boshqa rasmlar bo'lsa, birinchisini primary qilish
        if ($image->is_primary) {
            $nextImage = CarImage::where('car_id', $carId)
                ->where('id', '!=', $id)
                ->orderBy('order')
                ->first();
            if ($nextImage) {
                $nextImage->is_primary = true;
                $nextImage->save();
            }
        }
        
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}
