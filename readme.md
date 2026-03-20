# 🎬 Rasta Video Carousel (Elementor Widget)

A production-ready WordPress plugin that adds a **modern video carousel** to Elementor using Swiper.js (built into Elementor).

Supports **YouTube videos (all formats)** with a smooth **coverflow effect**, lazy loading, and click-to-play interaction.

---

## 🚀 Features

- ✅ Elementor widget integration
- ✅ Uses Elementor’s built-in Swiper (no extra library)
- ✅ Coverflow (3D-style) carousel effect
- ✅ Center-focused active slide
- ✅ Click-to-play (no iframe until needed)
- ✅ Lazy loading for performance
- ✅ Auto YouTube thumbnail extraction
- ✅ Supports all YouTube formats:
  - watch URLs
  - youtu.be links
  - embed links
  - shorts links

---

## 📁 Plugin Structure

rasta-video-carousel/
│
├── rasta-video-carousel.php
├── widget.php
└── assets/
├── js/
│ └── script.js
└── css/
└── style.css

---

## ⚙️ Installation

1. Download the plugin ZIP
2. Go to WordPress Admin → Plugins → Add New
3. Click **Upload Plugin**
4. Upload the ZIP file
5. Activate the plugin

---

## 🧩 Usage

1. Open a page with Elementor
2. Search for: `Rasta Video Carousel`
3. Drag and drop the widget
4. Add your video links (YouTube supported)

---

## 🔗 Supported Video Formats

The plugin automatically extracts video IDs from:

```js
https://www.youtube.com/watch?v=VIDEO_ID

https://youtu.be/VIDEO_ID

https://www.youtube.com/embed/VIDEO_ID

https://www.youtube.com/shorts/VIDEO_ID

https://m.youtube.com/watch?v=VIDEO_ID
```

---

## ⚡ Performance Optimization

- Videos are **not loaded initially**
- Only thumbnails are rendered
- Iframe loads **on click**

This ensures:

- Faster page load
- Better Core Web Vitals
- Improved mobile performance

---

## 🎨 Customization

- You can modify styles in: `assets/css/style.css`
- And behavior in: `assets/js/script.js`

---

## 🛠 Developer Notes

- Built for Elementor frontend lifecycle
- Uses `elementorFrontend.hooks`
- Swiper is loaded from Elementor core (`swiper` handle)
- Safe output using `esc_url` and `esc_attr`

---

## 👤 Author

**Adelola Kayode Samson**  
GitHub: https://github.com/xarmzon

---

## 📄 License

This project is open-source and free to use.

---

## ⭐ Support

If you like this plugin, consider:

- Starring the repo
- Sharing it
- Contributing improvements

---
