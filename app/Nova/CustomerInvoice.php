<?php

namespace App\Nova;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CustomerInvoice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<Invoice>
     */
    public static $model = Invoice::class;

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return 'My Invoices';
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return 'Invoice';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'invoice_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'invoice_number',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Determine if this resource is available for navigation.
     */
    public static function availableForNavigation(Request $request): bool
    {
        // Available for navigation for customers (will be shown in custom menu)
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Determine if the current user can view any resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        return self::isCustomerUser($request);
    }

    /**
     * Determine if the current user can view the resource.
     */
    public function authorizedToView(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Customers can only view their own invoices
        if ($user->isCustomer()) {
            return $this->isCustomerInvoice($user);
        }

        // Staff users can view all invoices (if they have permission)
        return true;
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::applyCustomerFilter($request, $query->with(['customer', 'lines']));
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::applyCustomerFilter($request, $query->with(['customer', 'lines', 'payments']));
    }

    /**
     * Build a "relatable" query for the given resource.
     */
    public static function relatableQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::indexQuery($request, $query);
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return false; // Customers cannot create invoices through Nova
    }

    /**
     * Determine if the current user can update the given resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        return false; // Customers cannot update invoices
    }

    /**
     * Determine if the current user can delete the given resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        return false; // Customers cannot delete invoices
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            $this->idField(),
            $this->invoiceNumberField(),
            $this->statusField(),
            $this->totalField(),
            $this->dueDateField(),
            $this->issueDateField(),
            $this->invoiceLinesField(),
            $this->paymentsField(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Check if the current user is a customer.
     */
    private static function isCustomerUser(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Check if the invoice belongs to the current customer.
     */
    private function isCustomerInvoice($user): bool
    {
        return $this->resource->customer_id === $user->userable_id;
    }

    /**
     * Apply customer filter to query.
     */
    private static function applyCustomerFilter(NovaRequest $request, Builder $query): Builder
    {
        if (self::isCustomerUser($request)) {
            return $query->where('customer_id', $request->user()->userable_id);
        }

        // If not a customer, return empty query
        return $query->whereRaw('1 = 0');
    }

    /**
     * Get the ID field.
     */
    private function idField(): ID
    {
        return ID::make()->sortable()->hideFromIndex();
    }

    /**
     * Get the invoice number field.
     */
    private function invoiceNumberField(): Text
    {
        return Text::make('Invoice Number', 'invoice_number')
            ->sortable()
            ->readonly();
    }

    /**
     * Get the status field.
     */
    private function statusField(): Badge
    {
        return Badge::make('Status')->map([
            'draft' => 'secondary',
            'sent' => 'info',
            'paid' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'danger',
        ])->sortable();
    }

    /**
     * Get the total field.
     */
    private function totalField(): Currency
    {
        return Currency::make('Total')
            ->currency('USD')
            ->sortable()
            ->readonly();
    }

    /**
     * Get the due date field.
     */
    private function dueDateField(): DateTime
    {
        return DateTime::make('Due Date', 'due_date')
            ->sortable()
            ->readonly()
            ->displayUsing(fn($value) => $value?->format('M d, Y'));
    }

    /**
     * Get the issue date field.
     */
    private function issueDateField(): DateTime
    {
        return DateTime::make('Issue Date', 'issue_date')
            ->sortable()
            ->readonly()
            ->hideFromIndex()
            ->displayUsing(fn($value) => $value?->format('M d, Y'));
    }

    /**
     * Get the invoice lines field.
     */
    private function invoiceLinesField(): HasMany
    {
        return HasMany::make('Invoice Lines', 'lines', CustomerInvoiceLine::class)
            ->readonly();
    }

    /**
     * Get the payments field.
     */
    private function paymentsField(): HasMany
    {
        return HasMany::make('Payments', 'payments', CustomerPayment::class)
            ->readonly();
    }
}
