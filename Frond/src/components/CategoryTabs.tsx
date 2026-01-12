import { cn } from '@/lib/utils';
import { CategoryName } from '@/types/car';

interface CategoryTabsProps {
  selected: CategoryName | 'Barchasi';
  onChange: (category: CategoryName | 'Barchasi') => void;
}

const allCategories: (CategoryName | 'Barchasi')[] = ['Barchasi', 'Sedan', 'SUV', 'Hatchback', 'Coupe', 'Electric'];

const categoryIcons: Record<CategoryName | 'Barchasi', string> = {
  'Barchasi': '🚗',
  'Sedan': '🚙',
  'SUV': '🚐',
  'Hatchback': '🚕',
  'Coupe': '🏎️',
  'Electric': '⚡',
};

export function CategoryTabs({ selected, onChange }: CategoryTabsProps) {
  return (
    <div className="px-4 pb-3">
      <div className="flex gap-2 overflow-x-auto no-scrollbar">
        {allCategories.map((category) => (
          <button
            key={category}
            onClick={() => onChange(category)}
            className={cn(
              'flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap transition-all shrink-0',
              selected === category
                ? 'bg-primary text-primary-foreground shadow-lg'
                : 'bg-card text-muted-foreground hover:bg-muted'
            )}
          >
            <span>{categoryIcons[category]}</span>
            <span>{category}</span>
          </button>
        ))}
      </div>
    </div>
  );
}
