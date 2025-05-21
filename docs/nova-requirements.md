# WHMCS-like Billing System with Laravel Nova

## Project Overview

This document outlines the requirements and implementation plan for developing a WHMCS-like billing and hosting management system using Laravel Nova. By leveraging Nova's powerful admin panel capabilities, we'll create a comprehensive hosting management platform with minimal custom frontend development.

## Technology Stack

### Backend
- **Laravel 12** - PHP framework
- **Laravel Nova 4** - Admin panel framework
- **MySQL Database** - Relational database
- **Laravel Sanctum** - API authentication

### Frontend
- **Laravel Nova** for admin dashboard
- **Blade + Livewire** for customer portal
- **Tailwind CSS** for styling

### Development Tools
- **Laravel Nova Resource Generator** for rapid resource creation
- **Laravel Nova Actions** for batch processing and workflows
- **Laravel Nova Metrics** for dashboard analytics
- **Laravel Nova Filters** for advanced data filtering

## Why Laravel Nova for This Project

1. **Rapid Development**: Nova provides pre-built CRUD interfaces that will accelerate development
2. **Resource Relationships**: Built-in handling of complex relationships needed for billing systems
3. **Authorization**: Granular permissions system that maps well to our roles/permissions requirements
4. **Actions Framework**: Perfect for order processing, service provisioning, and other workflows
5. **Metrics and Reporting**: Built-in dashboard metrics for financial and customer reporting
6. **API Integration**: Seamless Laravel API development for customer portal and service integrations

## Core System Requirements

### 1. User Management

#### Customers (Nova Resource)
- **Fields:** 
  - id
  - first_name
  - last_name
  - email
  - phone
  - password
  - address
  - city
  - state
  - country
  - postal_code
  - company_name
  - status (active/inactive)
  - creation_date
  - last_login
- **Actions:** 
  - Register
  - Login
  - Update Profile
  - Reset Password
  - Suspend/Activate (Nova Action)
  - View Services
  - View Invoices
- **Relationships:** 
  - HasMany orders
  - HasMany subscriptions
  - HasMany tickets
  - HasMany invoices
- **Nova Features:**
  - Avatar field for customer profile
  - Status badges using Nova Badge field
  - Custom detail view with service summary
  - Metrics for customer growth and activity

#### Admin Users (Nova Resource)
- **Fields:** 
  - id
  - first_name
  - last_name
  - email
  - phone
  - password
  - role_id
  - department_id
  - status
  - last_login
- **Actions:** 
  - Login
  - Manage Customers (via Nova policies)
  - Handle Tickets (via Nova actions)
  - Process Orders (via Nova actions)
- **Relationships:** 
  - BelongsTo role
  - BelongsTo department
- **Nova Features:**
  - Integration with Nova's built-in user management
  - Role-based access control using Nova policies
  - Staff activity logs using Nova's action events

### 2. Permissions & Role Management

#### Permissions (Nova Resource)
- **Fields:** 
  - id
  - name
  - slug
  - description
  - module
- **Relationships:** 
  - BelongsToMany roles
- **Nova Features:**
  - Grouped by module using Nova's grouping features
  - Select fields for assigning permissions to roles

#### Roles (Nova Resource)
- **Fields:** 
  - id
  - name
  - description
  - is_system
- **Actions:** 
  - Create Role
  - Edit Role
  - Assign Permissions (Nova Action)
  - Assign to Staff (Nova Action)
- **Relationships:** 
  - HasMany staff
  - BelongsToMany permissions
- **Nova Features:**
  - Permission management using BelongsToMany field
  - Toggle field for system roles
  - Custom Nova action for syncing permissions

### 3. Order Management (Nova Resource)
- **Fields:** 
  - id
  - customer_id
  - order_number
  - status
  - total
  - payment_method
  - creation_date
  - notes
- **Actions:** 
  - Create Order (Nova Action)
  - Process Order (Nova Action with workflow)
  - Change Status (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - HasMany hosting_accounts
  - HasMany domains
- **Nova Features:**
  - Custom Nova Action for order processing workflow
  - Status tracking with color-coded badges
  - JSON field for order items
  - Custom Nova panel for order details

### 4. Package Management

#### Products/Packages (Nova Resource)
- **Fields:** 
  - id
  - name
  - description
  - type (hosting/domain)
  - setup_fee
  - recurring_amount
  - billing_cycle
  - server_group_id
  - features_json
  - status
- **Actions:** 
  - Create Package
  - Update Package
  - Assign to Server Group (Nova Action)
- **Relationships:** 
  - BelongsTo server_group
- **Nova Features:**
  - KeyValue field for features
  - Select field for package type
  - Currency field for pricing
  - Boolean field for featured status
  - Markdown field for rich descriptions

### 5. Invoice Management

#### Invoices (Nova Resource)
- **Fields:** 
  - id
  - customer_id
  - invoice_number
  - creation_date
  - due_date
  - status
  - subtotal
  - tax_amount
  - total
  - balance_due
- **Actions:** 
  - Generate Invoice (Nova Action)
  - Send Invoice (Nova Action)
  - Record Payment (Nova Action)
  - Mark as Paid (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - HasMany invoice_lines
- **Nova Features:**
  - Currency fields for monetary values
  - Status badges with color coding
  - PDF generation action
  - Email sending action
  - Custom metrics for revenue tracking

#### Invoice Lines (Nova Resource)
- **Fields:** 
  - id
  - invoice_id
  - description
  - amount
  - type (hosting/domain)
  - hosting_account_id (nullable)
  - domain_id (nullable)
- **Relationships:** 
  - BelongsTo invoice
  - MorphTo service (polymorphic to hosting_account or domain)
- **Nova Features:**
  - MorphTo field for service relationship
  - Currency field for amount
  - Belongs to field for invoice

### 6. Payment Management

#### Payment Methods (Nova Resource)
- **Fields:** 
  - id
  - name (SSLCommerz/PayPal)
  - gateway
  - is_active
  - config_json
- **Actions:** 
  - Enable/Disable Gateway (Nova Toggle)
  - Update Configuration
- **Nova Features:**
  - JSON editor for gateway configuration
  - Boolean toggle for active status
  - Code field for gateway integration code

#### Transactions (Nova Resource)
- **Fields:** 
  - id
  - invoice_id
  - customer_id
  - date
  - payment_method
  - amount
  - transaction_id
  - status
- **Actions:** 
  - Process Payment (Nova Action)
  - Record Transaction (Nova Action)
- **Relationships:** 
  - BelongsTo invoice
  - BelongsTo customer
- **Nova Features:**
  - Currency field for amount
  - Status badges
  - Date field with time
  - Custom index view with summary

### 7. Subscription Management (Nova Resource)
- **Fields:** 
  - id
  - customer_id
  - status
  - creation_date
  - next_due_date
  - billing_cycle
  - amount
  - hosting_account_id (nullable)
  - domain_id (nullable)
- **Actions:** 
  - Create Subscription (Nova Action)
  - Cancel Subscription (Nova Action)
  - Change Billing Cycle (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - MorphTo service (polymorphic to hosting_account or domain)
- **Nova Features:**
  - Date field for next billing date
  - Select field for billing cycle
  - Currency field for amount
  - Status badges for subscription status
  - Metrics for recurring revenue

### 8. Hosting Management

#### Servers (Nova Resource)
- **Fields:** 
  - id
  - name
  - hostname
  - ip_address
  - type (cpanel/virtualizor)
  - username
  - password (encrypted)
  - api_token (encrypted)
  - server_group_id
  - status
- **Actions:** 
  - Connect Server (Nova Action)
  - Test Connection (Nova Action)
  - Sync Accounts (Nova Action)
- **Relationships:** 
  - BelongsTo server_group
  - HasMany hosting_accounts
- **Nova Features:**
  - Password field for secure credential storage
  - Status indicator with server health
  - Custom Nova action for API testing
  - Metrics for server usage

#### Server Groups (Nova Resource)
- **Fields:** 
  - id
  - name
  - fill_method (round-robin/least-used)
- **Actions:** 
  - Create Group
  - Assign Servers (Nova Action)
- **Relationships:** 
  - HasMany servers
- **Nova Features:**
  - Select field for fill method
  - BelongsToMany field for server assignment
  - Summary metrics for group capacity

#### Hosting Accounts (Nova Resource)
- **Fields:** 
  - id
  - customer_id
  - order_id
  - subscription_id
  - server_id
  - username
  - password (encrypted)
  - domain
  - package_id
  - status
- **Actions:** 
  - Create Account (Nova Action with API integration)
  - Suspend Account (Nova Action)
  - Unsuspend Account (Nova Action)
  - Terminate Account (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - BelongsTo order
  - BelongsTo server
  - BelongsTo subscription
  - BelongsTo package
- **Nova Features:**
  - Password field for encrypted storage
  - Status badges
  - Custom actions for cPanel/Virtualizor API integration
  - Resource metrics for disk/bandwidth

### 9. Ticket Management

#### Departments (Nova Resource)
- **Fields:** 
  - id
  - name
  - description
  - email
- **Actions:** 
  - Create Department
  - Assign Staff (Nova Action)
- **Relationships:** 
  - HasMany staff
  - HasMany tickets
- **Nova Features:**
  - BelongsToMany field for staff assignment
  - Metrics for department ticket volume

#### Tickets (Nova Resource)
- **Fields:** 
  - id
  - ticket_number
  - customer_id
  - department_id
  - subject
  - status
  - priority
  - created_date
  - assigned_staff_id
- **Actions:** 
  - Open Ticket
  - Assign Ticket (Nova Action)
  - Close Ticket (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - BelongsTo department
  - BelongsTo staff (assigned)
  - HasMany replies
- **Nova Features:**
  - Priority badges with color coding
  - Status badges
  - Custom detail view for ticket thread
  - Metrics for response time and resolution
  - Custom Nova Actions for ticket workflow

#### Ticket Replies (Nova Resource)
- **Fields:** 
  - id
  - ticket_id
  - user_id
  - user_type (staff/customer)
  - message
  - date
- **Actions:** 
  - Post Reply (Nova Action)
  - Add Note (Nova Action)
- **Relationships:** 
  - BelongsTo ticket
  - MorphTo user (polymorphic to staff or customer)
- **Nova Features:**
  - Trix editor for rich text replies
  - File upload for attachments
  - Timeline display in ticket detail

### 10. Domain Management (Nova Resource)
- **Fields:** 
  - id
  - customer_id
  - order_id
  - subscription_id
  - domain_name
  - registration_date
  - expiry_date
  - status
  - nameservers_json
- **Actions:** 
  - Register Domain (Nova Action)
  - Renew Domain (Nova Action)
  - Update Nameservers (Nova Action)
- **Relationships:** 
  - BelongsTo customer
  - BelongsTo order
  - BelongsTo subscription
- **Nova Features:**
  - JSON field for nameservers
  - Date fields for registration/expiry
  - Domain validation rules
  - Custom metrics for domain registrations
  - Expiry warnings and notifications

## Nova Dashboard Design

### Admin Dashboard Metrics
- **Revenue Cards**:
  - Today's Revenue (Value Metric)
  - This Month's Revenue (Trend Metric)
  - Revenue by Service Type (Partition Metric)
  - Outstanding Invoices (Value Metric)
- **Customer Cards**:
  - New Customers (Trend Metric)
  - Active Services (Value Metric)
  - Customer Growth (Trend Metric)
- **Support Cards**:
  - Open Tickets (Value Metric)
  - Average Response Time (Value Metric)
  - Tickets by Department (Partition Metric)
- **Service Cards**:
  - Active Hosting Accounts (Value Metric)
  - Server Utilization (Partition Metric)
  - Domains by TLD (Partition Metric)

### Custom Lenses
- **Overdue Invoices Lens**
- **Expiring Services Lens**
- **Server Status Lens**
- **Top Customers Lens**

## Implementation Plan

### Phase 1: Nova Setup & Core Resources (2 weeks)
- Set up Laravel with Nova installation
- Configure Nova admin theme and branding
- Create core Nova resources:
  - Customers
  - Admin Users
  - Roles and Permissions
  - Basic dashboard metrics
- Configure Nova policies and gates
- Set up authentication for both admin and customers

### Phase 2: Product & Server Management (2 weeks)
- Implement package management resources
- Create server and server group resources
- Set up hosting account resource
- Create domain management resource
- Implement server connection testing
- Configure Nova actions for server management

### Phase 3: Order & Billing System (3 weeks)
- Create order management resource
- Implement invoice and invoice line resources
- Set up subscription management
- Create payment methods and transaction resources
- Implement Nova actions for:
  - Order processing workflow
  - Invoice generation and sending
  - Payment recording
- Build Nova metrics for financial reporting

### Phase 4: Service Provisioning & APIs (2 weeks)
- Integrate with cPanel API
- Integrate with Virtualizor API
- Create domain registrar integration
- Implement automated provisioning via Nova actions
- Build service management workflows
- Create customer portal API endpoints

### Phase 5: Support System & Customer Portal (2 weeks)
- Implement ticket system resources
- Create department management
- Build ticket assignment and workflow actions
- Develop customer portal with Blade and Livewire
- Create customer dashboard
- Implement service management UI for customers

## Laravel Nova Best Practices

### 1. Resource Organization
- Group related resources under directories
- Create custom resource navigation menu
- Use resource policies for authorization
- Implement custom resource detail pages where needed

### 2. Field Customization
- Use field types appropriate for data (Currency, KeyValue, Select, etc.)
- Create custom fields for complex data representation
- Use field visibility callbacks to conditionally show fields
- Implement computed fields for derived data

### 3. Action Implementation
- Create multi-step actions for complex workflows
- Use action validation rules
- Implement confirmation dialogs for destructive actions
- Create action event listeners for logging

### 4. Metrics & Reporting
- Implement value, trend, and partition metrics
- Create resource-specific metrics
- Use caching for performance
- Set appropriate refresh intervals

### 5. API Integration
- Create service classes for external APIs
- Use Laravel's HTTP client for API communication
- Implement error handling and retry logic
- Create Nova actions that wrap API functionality

### 6. Performance Optimization
- Use eager loading for relationships
- Create custom indexes for frequently queried fields
- Implement database indexing strategy
- Use caching where appropriate
- Configure queue for background processing

## Deployment Considerations
- Set up proper environment configuration
- Configure Nova license properly
- Implement backup strategy
- Set up scheduled tasks for recurring billing
- Configure proper queue workers for background jobs
- Set up monitoring for server health

This document serves as the primary reference for implementing a WHMCS-like system using Laravel Nova. By leveraging Nova's capabilities, we can rapidly build a powerful admin interface and focus on business logic rather than UI development.
