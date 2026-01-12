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
        $admins = User::whereIn('role', ['admin', 'moderator'])->orderBy('name')->get();
        return view('admin.admins', compact('admins'));
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
