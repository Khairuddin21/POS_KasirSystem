# 🎨 Color Scheme & Design System

## Inspired by Pawoon.com

### Primary Colors
```css
--cyan-400: #22d3ee
--cyan-500: #06b6d4  /* Main brand color */
--cyan-600: #0891b2
--blue-500: #3b82f6
--blue-600: #2563eb
```

### Secondary Colors
```css
--gray-50: #f9fafb   /* Light backgrounds */
--gray-100: #f3f4f6
--gray-600: #4b5563  /* Body text */
--gray-700: #374151
--gray-800: #1f2937  /* Headings */
--gray-900: #111827  /* Footer */
```

### Accent Colors
```css
--green-500: #10b981  /* WhatsApp button */
--green-600: #059669
--yellow-300: #fcd34d  /* Highlights */
--purple-500: #8b5cf6
```

## Gradients

### Hero Gradient
```css
background: linear-gradient(to bottom right, #22d3ee, #06b6d4, #0891b2);
```

### Button Gradient
```css
background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
```

### Overlay Gradient
```css
background: linear-gradient(135deg, rgba(6, 182, 212, 0.9) 0%, rgba(59, 130, 246, 0.9) 100%);
```

## Typography

### Font Family
```css
font-family: 'Figtree', sans-serif;
```

### Font Weights
- Regular: 400
- Medium: 500
- Semibold: 600
- Bold: 700
- Extrabold: 800

### Font Sizes
```css
/* Hero Heading */
text-5xl: 3rem / 1   /* Mobile: text-4xl: 2.25rem */

/* Section Headings */
text-4xl: 2.25rem / 2.5rem

/* Subheadings */
text-2xl: 1.5rem / 2rem
text-xl: 1.25rem / 1.75rem

/* Body Text */
text-base: 1rem / 1.5rem
text-lg: 1.125rem / 1.75rem
```

## Spacing

### Container
```css
max-width: 1280px
padding: 0 1.5rem (24px)
```

### Section Padding
```css
py-20: 5rem (80px) vertical
px-6: 1.5rem (24px) horizontal
```

### Card Padding
```css
p-8: 2rem (32px)
```

## Border Radius
```css
rounded-full: 9999px  /* Buttons */
rounded-2xl: 1rem     /* Cards */
rounded-xl: 0.75rem   /* Icons */
```

## Shadows
```css
/* Default Card */
shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1)

/* Hover Card */
shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25)

/* Button Shadow */
shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1)
```

## Animations

### Duration
```css
duration-300: 300ms  /* Default transitions */
duration-500: 500ms
```

### Timing Functions
```css
ease-out: cubic-bezier(0, 0, 0.2, 1)
ease-in-out: cubic-bezier(0.4, 0, 0.2, 1)
```

### Transform Effects
```css
/* Hover Lift */
transform: translateY(-8px)

/* Button Hover */
transform: translateY(-2px)
```

## Component Styles

### Primary Button
```css
.btn-primary {
  background: #06b6d4;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 9999px;
  font-weight: 700;
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px -5px rgba(6, 182, 212, 0.5);
}

.btn-primary:hover {
  background: #0891b2;
  transform: translateY(-2px);
  box-shadow: 0 20px 25px -5px rgba(6, 182, 212, 0.7);
}
```

### Feature Card
```css
.feature-card {
  background: white;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
```

### Icon Container
```css
.icon-container {
  width: 4rem;
  height: 4rem;
  background: #06b6d4;
  border-radius: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
```

## Breakpoints

### Mobile First Approach
```css
/* Mobile: default (< 768px) */
/* Tablet: md: min-width 768px */
/* Desktop: lg: min-width 1024px */
/* Large: xl: min-width 1280px */
```

## Accessibility

### Focus States
```css
a:focus, button:focus {
  outline: 2px solid #06b6d4;
  outline-offset: 2px;
}
```

### Color Contrast
- All text meets WCAG AA standards
- Primary text: #1f2937 on white background (15.1:1)
- Body text: #4b5563 on white background (7.5:1)

## Best Practices

1. **Consistency**: Use the same cyan-blue gradient throughout
2. **Spacing**: Maintain consistent padding and margins
3. **Hover States**: All interactive elements have hover effects
4. **Animations**: Keep animations smooth (300ms duration)
5. **Shadows**: Use shadows to create depth hierarchy
6. **Typography**: Maintain clear visual hierarchy
7. **Accessibility**: Ensure all elements are keyboard accessible

---

**Design System Version**: 1.0
**Last Updated**: October 23, 2025
**Status**: Active & Implemented
