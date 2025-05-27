# Customer Portal - Nova Tool

A comprehensive customer portal tool for Laravel Nova that provides customers with access to their orders, invoices, services, support tickets, and profile management.

## 📁 Project Structure

```
nova-components/CustomerPortal/
├── resources/js/
│   ├── components/           # Vue components for remaining sections
│   │   ├── Support.vue       # Support ticket system
│   │   └── Profile.vue       # Customer profile management
│   ├── utils/
│   │   └── helpers.js        # Shared utilities and API helpers
│   └── tool.js               # Tool entry point
├── routes/
│   ├── api.php               # API routes for customer data
│   └── inertia.php           # Inertia routes for tool pages
├── src/
│   ├── CustomerPortal.php    # Main tool class
│   └── Http/Middleware/
│       └── Authorize.php     # Authorization middleware
└── README.md                 # This file
```

## 🧩 Components Overview

**Note**: Orders, Invoices, and Services are now handled by Nova resources instead of Vue components.

### Support.vue
- **Purpose**: Support ticket system
- **Features**:
  - Complete ticket management with filtering and search
  - Ticket creation, tracking, and responses
  - Status and priority management
  - Pagination and real-time updates
- **API**: `/nova-vendor/customer-portal/tickets`

### Profile.vue
- **Purpose**: Customer profile management
- **Features**:
  - Complete profile editing with form validation
  - Secure password change functionality
  - Account information display
  - Real-time form updates
- **API**: `/nova-vendor/customer-portal/profile`

## 🛠 Utilities (helpers.js)

### Helper Functions
- `formatMoney(amount)` - Format currency with commas
- `formatDate(date)` - Format dates to readable format
- `getInitials(name)` - Extract initials from names
- `getOrderStatusClass(status)` - CSS classes for order status
- `getInvoiceStatusClass(status)` - CSS classes for invoice status
- `getCustomerStatusClass(status)` - CSS classes for customer status

### API Helper Class
- `CustomerPortalAPI.getDashboardData()` - Load dashboard data
- `CustomerPortalAPI.getOrders()` - Load customer orders
- `CustomerPortalAPI.getInvoices()` - Load customer invoices
- `CustomerPortalAPI.getTickets()` - Load support tickets

## 🔧 Development

### Building the Tool
```bash
cd nova-components/CustomerPortal
npm run production
```

### Adding New Components
1. Create new Vue component in `resources/js/components/`
2. Import in `Tool.vue`
3. Add to components object
4. Add route handling in `setupRouteWatcher()`
5. Add API endpoint if needed

### Adding New API Endpoints
1. Add route in `routes/api.php`
2. Add method to `CustomerPortalAPI` class in `helpers.js`
3. Use in component

## 🎨 Styling

The tool uses Nova's built-in components and styling:
- `<Card>` - Nova card component
- `<Heading>` - Nova heading component
- Tailwind CSS classes for layout and styling

## 🔐 Authorization

- Tool is only visible to customers (`$user->isCustomer()`)
- API routes are protected by tool's authorization middleware
- Each component handles its own data loading

## 📋 TODO / Future Enhancements

### Services Component
- [ ] Service status display
- [ ] Configuration options
- [ ] Renewal management
- [ ] Usage statistics

### Profile Component
- [ ] Profile editing form
- [ ] Password change
- [ ] Notification preferences
- [ ] Account settings

### Orders Component
- [ ] Order tracking
- [ ] Order details modal
- [ ] Reorder functionality
- [ ] Order status updates

### Invoices Component
- [ ] Invoice PDF download
- [ ] Payment processing
- [ ] Payment history
- [ ] Invoice details modal

### Support Component
- [ ] Ticket creation form
- [ ] File attachments
- [ ] Real-time updates
- [ ] Knowledge base integration

## 🚀 Deployment

1. Build the tool: `npm run production`
2. Clear Laravel cache: `php artisan cache:clear`
3. The tool will be automatically available in Nova sidebar for customers

## 📝 Notes

- All components are self-contained with their own data loading
- Shared functionality is extracted to `helpers.js`
- API calls are centralized in `CustomerPortalAPI` class
- Components follow Vue.js best practices
- Tool integrates seamlessly with Nova's design system
