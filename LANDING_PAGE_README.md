# POS Kasir - Modern Point of Sale System

Sistem kasir digital modern dengan interface yang elegan dan fitur lengkap untuk berbagai jenis bisnis.

## 🎨 Design Concept

Landing page ini terinspirasi dari desain Pawoon dengan warna tema **Cyan/Turquoise** yang modern dan profesional.

### Color Palette
- **Primary**: Cyan (#06b6d4)
- **Secondary**: Blue (#3b82f6)
- **Accent**: Purple (#a855f7)
- **Admin**: Cyan/Gray theme
- **Kasir**: Blue theme
- **User**: Purple theme

## 🚀 Features

### Landing Page
- ✅ Modern hero section dengan floating animations
- ✅ Feature cards dengan hover effects
- ✅ Role-based access sections (Admin, Kasir, User)
- ✅ Smooth scroll navigation
- ✅ Responsive mobile menu
- ✅ Custom animations (fade-in, slide, floating)
- ✅ Intersection observer untuk scroll animations

### Role-Based Dashboards

#### 1. Admin Dashboard
- Full control panel dengan sidebar navigation
- User management
- Product management
- Transaction monitoring
- Reports & Analytics
- System settings
- **Color Theme**: Dark Gray with Cyan accents

#### 2. Kasir Dashboard
- Quick transaction interface
- Daily sales monitoring
- Transaction history
- Product catalog
- Daily reports
- Receipt printing
- **Color Theme**: Blue

#### 3. User Dashboard
- Personal transaction history
- Profile management
- Purchase overview
- Notifications
- **Color Theme**: Purple

## 📁 Project Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── main.blade.php          # Main layout template
│   │   ├── admin.blade.php         # Admin layout with sidebar
│   │   ├── kasir.blade.php         # Kasir layout with sidebar
│   │   └── user.blade.php          # User layout with header/footer
│   ├── components/
│   │   ├── admin/
│   │   │   ├── sidebar.blade.php   # Admin sidebar navigation
│   │   │   └── header.blade.php    # Admin header
│   │   ├── kasir/
│   │   │   ├── sidebar.blade.php   # Kasir sidebar navigation
│   │   │   └── header.blade.php    # Kasir header
│   │   └── user/
│   │       ├── header.blade.php    # User header navigation
│   │       └── footer.blade.php    # User footer
│   ├── admin/
│   │   └── dashboard.blade.php     # Admin dashboard
│   ├── kasir/
│   │   └── dashboard.blade.php     # Kasir dashboard
│   ├── user/
│   │   └── dashboard.blade.php     # User dashboard
│   └── landing.blade.php           # Main landing page
├── css/
│   └── app.css                     # Custom styles with animations
└── js/
    └── app.js                      # Custom JavaScript for interactivity
```

## 🎯 Routes

### Public Routes
- `/` - Landing page
- `/login` - General login
- `/register` - Registration

### Admin Routes
- `/admin/login` - Admin login
- `/admin/dashboard` - Admin dashboard
- `/admin/users` - User management
- `/admin/products` - Product management
- `/admin/transactions` - Transaction management
- `/admin/reports` - Reports & analytics
- `/admin/settings` - System settings

### Kasir Routes
- `/kasir/login` - Kasir login
- `/kasir/dashboard` - Kasir dashboard
- `/kasir/transaction` - New transaction
- `/kasir/history` - Transaction history
- `/kasir/products` - Product list
- `/kasir/report` - Daily report

### User Routes
- `/user/login` - User login
- `/user/dashboard` - User dashboard
- `/user/transactions` - Transaction history
- `/user/profile` - User profile
- `/user/settings` - User settings

## 🎨 Custom Animations

### CSS Animations
- **fadeIn**: Smooth fade-in from bottom
- **fadeInLeft**: Fade and slide from left
- **fadeInRight**: Fade and slide from right
- **floating**: Continuous floating effect
- **slideDown**: Drop-down animation
- **shimmer**: Loading skeleton animation

### JavaScript Features
- Navbar scroll effect (sticky header with shadow)
- Mobile menu toggle
- Smooth scroll to sections
- Intersection Observer for scroll animations
- Active navigation link highlighting
- Button ripple effects
- Parallax scrolling on hero section

## 🛠️ Installation & Setup

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- Laravel 11

### Steps

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database Migration**
```bash
php artisan migrate
```

4. **Build Assets**
```bash
npm run dev
# or for production
npm run build
```

5. **Start Development Server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to see the landing page.

## 🎨 Styling with Tailwind CSS

This project uses Tailwind CSS with custom extensions:

- **Custom colors**: Cyan, Blue, Purple palettes
- **Custom animations**: Defined in `app.css`
- **Responsive design**: Mobile-first approach
- **Dark mode ready**: Prepared for dark theme implementation

## 📱 Responsive Design

- **Mobile**: < 768px (Mobile menu, stacked layouts)
- **Tablet**: 768px - 1024px (2-column grids)
- **Desktop**: > 1024px (Full layout with sidebars)

## 🔐 Security Notes

- Implement proper authentication middleware
- Add CSRF protection to forms
- Validate all user inputs
- Implement role-based access control (RBAC)
- Sanitize database queries

## 🚧 TODO / Next Steps

- [ ] Implement authentication system
- [ ] Add role-based middleware
- [ ] Connect to database
- [ ] Implement CRUD operations
- [ ] Add real-time notifications
- [ ] Implement payment gateway
- [ ] Add reporting features
- [ ] Create API endpoints
- [ ] Add testing (PHPUnit, Jest)
- [ ] Deploy to production

## 📝 Customization

### Changing Colors

Edit `tailwind.config.js`:
```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        'primary': '#06b6d4',  // Change cyan color
        'secondary': '#3b82f6', // Change blue color
      }
    }
  }
}
```

### Adding New Roles

1. Create new layout in `resources/views/layouts/`
2. Create components in `resources/views/components/`
3. Add routes in `routes/web.php`
4. Create dashboard view
5. Add navigation items

## 🤝 Contributing

This is a custom POS system. For modifications:
1. Create a new branch
2. Make your changes
3. Test thoroughly
4. Submit for review

## 📄 License

Proprietary - All rights reserved

## 👥 Credits

- **Design Inspiration**: Pawoon (pawoon.com)
- **Framework**: Laravel 11
- **CSS Framework**: Tailwind CSS
- **Icons**: Heroicons
- **Fonts**: Figtree (Google Fonts)

## 📞 Support

For support and questions:
- Email: support@poskasir.com
- Documentation: [Coming Soon]

---

**Built with ❤️ for modern businesses**

Version: 1.0.0
Last Updated: October 23, 2024
