import React, { useEffect, useState } from "react";

interface ImageBannerProps {
  images: string[]; // expects 3 image URLs
  interval?: number; // auto-slide interval in ms (default 5000)
}

export default function ImageBanner({
  images,
  interval = 5000,
}: ImageBannerProps) {
  const [current, setCurrent] = useState(0);

  if (images.length === 0) return null;

  useEffect(() => {
    const timer = setInterval(() => {
      setCurrent((prev) => (prev + 1) % images.length);
    }, interval);

    return () => clearInterval(timer);
  }, [images.length, interval]);

  return (
    <div className="relative w-full h-56 sm:h-72 md:h-80 rounded-lg overflow-hidden shadow-lg">
      {/* Image Stack */}
      {images.map((src, index) => (
        <img
          key={index}
          src={src}
          alt=""
          loading="lazy"
          aria-hidden="true"
          className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out ${
            index === current ? "opacity-100" : "opacity-0"
          }`}
        />
      ))}

      {/* Text Overlay */}
      <div className="absolute inset-0 flex items-center justify-center bg-black/30">
        <h2 className="text-3xl sm:text-4xl md:text-5xl font-bold text-white text-center px-4">
          Bizning Hamkorlar
        </h2>
      </div>

      {/* Dot Indicators */}
      <div className="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2 items-center pointer-events-none">
        {images.map((_, i) => (
          <div
            key={i}
            className={`rounded-full transition-all duration-300 ${
              i === current
                ? "w-3 h-3 bg-white shadow-md"
                : "w-2 h-2 bg-white/60"
            }`}
          />
        ))}
      </div>
    </div>
  );
}
