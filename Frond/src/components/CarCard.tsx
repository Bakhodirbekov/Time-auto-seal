import { Car } from '@/types/car';
import { CountdownTimer } from './CountdownTimer';
import { useCountdown } from '@/hooks/useCountdown';
import { useAuth } from '@/contexts/AuthContext';
import { Heart, MapPin, Gauge, Fuel } from 'lucide-react';
import { cn } from '@/lib/utils';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

interface CarCardProps {
  car: Car;
}

export function CarCard({ car }: CarCardProps) {
  const { isAuthenticated, setShowAuthModal } = useAuth();
  const { isExpired } = useCountdown(car.timer_end_at);
  const [isFavorite, setIsFavorite] = useState(false);
  const [imageIndex, setImageIndex] = useState(0);
  const navigate = useNavigate();

  const canViewPrice = car.price_visible || isExpired;

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('uz-UZ').format(price) + ' so\'m';
  };

  const primaryImage = car.images.find(img => img.is_primary)?.image_url || car.images[0]?.image_url;
  const allImageUrls = car.images.map(img => img.image_url);

  const handleClick = () => {
    if (!isAuthenticated) {
      setShowAuthModal(true);
      return;
    }
    navigate(`/car/${car.id}`);
  };

  const handleFavorite = (e: React.MouseEvent) => {
    e.stopPropagation();
    if (!isAuthenticated) {
      setShowAuthModal(true);
      return;
    }
    setIsFavorite(!isFavorite);
  };

  return (
    <div 
      onClick={handleClick}
      className="bg-card rounded-2xl shadow-card card-hover cursor-pointer overflow-hidden"
    >
      {/* Image */}
      <div className="relative aspect-[4/3] overflow-hidden">
        <img
          src={allImageUrls[imageIndex] || '/placeholder-car.png'}
          alt={`${car.brand} ${car.model}`}
          className="w-full h-full object-cover"
        />
        
        {/* Hot Deal Badge */}
        {car.is_hot_deal && (
          <div className="absolute top-3 left-3 bg-accent text-accent-foreground px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1">
            🔥 Hot Deal
          </div>
        )}

        {/* Timer */}
        {!isExpired && (
          <div className="absolute top-3 right-3">
            <CountdownTimer timerEndAt={car.timer_end_at} compact />
          </div>
        )}

        {/* Favorite Button */}
        <button
          onClick={handleFavorite}
          className={cn(
            'absolute bottom-3 right-3 w-9 h-9 rounded-full flex items-center justify-center transition-all',
            isFavorite 
              ? 'bg-accent text-accent-foreground' 
              : 'bg-card/80 backdrop-blur-sm text-foreground hover:bg-card'
          )}
        >
          <Heart className={cn('w-4 h-4', isFavorite && 'fill-current')} />
        </button>

        {/* Image Dots */}
        {allImageUrls.length > 1 && (
          <div className="absolute bottom-3 left-3 flex gap-1">
            {allImageUrls.map((_, idx) => (
              <button
                key={idx}
                onClick={(e) => {
                  e.stopPropagation();
                  setImageIndex(idx);
                }}
                className={cn(
                  'w-1.5 h-1.5 rounded-full transition-all',
                  idx === imageIndex ? 'bg-card w-4' : 'bg-card/50'
                )}
              />
            ))}
          </div>
        )}
      </div>

      {/* Content */}
      <div className="p-4">
        <div className="flex items-start justify-between mb-2">
          <div>
            <h3 className="font-bold text-foreground">
              {car.brand} {car.model}
            </h3>
            <p className="text-sm text-muted-foreground">{car.year} yil • {car.category?.name}</p>
          </div>
        </div>

        {/* Price */}
        <div className="mb-3">
          {canViewPrice ? (
            <p className="text-lg font-bold text-accent">
              {formatPrice(car.price)}
            </p>
          ) : (
            <div className="flex items-center gap-2">
              <p className="text-lg font-bold blur-price text-muted-foreground">
                {formatPrice(car.price)}
              </p>
              <span className="text-xs text-muted-foreground">
                ⏳ Kuting
              </span>
            </div>
          )}
        </div>

        {/* Quick Info */}
        <div className="flex flex-wrap gap-2 text-xs text-muted-foreground">
          <div className="flex items-center gap-1">
            <MapPin className="w-3 h-3" />
            {car.location || 'Noma\'lum'}
          </div>
          {car.mileage !== undefined && (
            <div className="flex items-center gap-1">
              <Gauge className="w-3 h-3" />
              {car.mileage.toLocaleString()} km
            </div>
          )}
          <div className="flex items-center gap-1">
            <Fuel className="w-3 h-3" />
            {car.fuel_type}
          </div>
        </div>
      </div>
    </div>
  );
}
