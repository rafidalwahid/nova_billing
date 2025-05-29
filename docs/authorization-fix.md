# Customer Support Authorization Fix

## Issue
Customers were getting "Sorry! You are not authorized to perform this action" when trying to add responses to tickets.

## Root Cause
Nova actions require the `update` permission on the model to run. The TicketPolicy was blocking customers from updating tickets, which prevented them from running any actions.

## Solution

### 1. Updated TicketPolicy
**File**: `app/Policies/TicketPolicy.php`

**Before**:
```php
public function update(User $user, Ticket $ticket): bool
{
    // Customers cannot update tickets (only add responses)
    if ($user->isCustomer()) {
        return false;
    }
    // ...
}
```

**After**:
```php
public function update(User $user, Ticket $ticket): bool
{
    // Customers can "update" tickets only for adding responses (Nova actions require this)
    if ($user->isCustomer()) {
        return $this->isCustomerOwner($user, $ticket);
    }
    // ...
}
```

### 2. Protected Ticket Resource from Direct Editing
**File**: `app/Nova/Ticket.php`

**Added protection**:
```php
public function authorizedToUpdate(Request $request): bool
{
    // Customers cannot access the edit form (but can run actions via policy)
    if ($user->isCustomer()) {
        return false;
    }
    // ...
}
```

**Made fields readonly for customers**:
```php
Text::make('Subject')
    ->readonly(function ($request) {
        return $request->user() && $request->user()->isCustomer();
    }),
```

## Result

### ✅ **What Customers CAN Do**:
- View their own tickets
- Run the "Reply to Ticket" action
- Add messages and attachments through actions
- View the conversation thread

### ❌ **What Customers CANNOT Do**:
- Access the ticket edit form
- Modify ticket fields directly
- Change status, priority, or assignment
- View or edit other customers' tickets

### ✅ **What Staff CAN Do**:
- Everything customers can do
- Access ticket edit forms
- Modify all ticket fields
- Run all staff actions
- View all tickets

## Technical Details

### Authorization Flow
1. **Nova Action Authorization**: Checks `$user->can('update', $ticket)` via TicketPolicy
2. **TicketPolicy**: Allows customers to "update" their own tickets (for actions only)
3. **Nova Resource Authorization**: Prevents customers from accessing edit forms
4. **Field-Level Protection**: Makes fields readonly for customers

### Security
- Customers can only run actions on their own tickets
- Customers cannot modify ticket data directly
- All customer actions are properly validated
- Staff permissions remain unchanged

This solution maintains security while enabling the intended customer functionality.
