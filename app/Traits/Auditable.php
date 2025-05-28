<?php

namespace App\Traits;

use App\Models\AuditLog;
use App\Services\AuditService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Auditable
{
    /**
     * Boot the auditable trait.
     */
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            $model->auditCreated();
        });

        static::updated(function ($model) {
            $model->auditUpdated();
        });

        static::deleted(function ($model) {
            $model->auditDeleted();
        });
    }

    /**
     * Get all audit logs for this model.
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * Audit model creation.
     */
    protected function auditCreated()
    {
        $auditService = app(AuditService::class);
        $category = $this->getAuditCategory();
        
        $auditService->logCreated($this, $category, $this->getAuditMetadata());
    }

    /**
     * Audit model update.
     */
    protected function auditUpdated()
    {
        $auditService = app(AuditService::class);
        $category = $this->getAuditCategory();
        
        // Get the original values before the update
        $oldValues = $this->getOriginal();
        
        $auditService->logUpdated($this, $oldValues, $category, $this->getAuditMetadata());
    }

    /**
     * Audit model deletion.
     */
    protected function auditDeleted()
    {
        $auditService = app(AuditService::class);
        $category = $this->getAuditCategory();
        
        $auditService->logDeleted($this, $category, $this->getAuditMetadata());
    }

    /**
     * Get the audit category for this model.
     * Override this method in your models to specify the category.
     */
    protected function getAuditCategory(): string
    {
        // Default category mapping based on model type
        $modelName = class_basename($this);
        
        return match($modelName) {
            'Invoice', 'Payment', 'Transaction', 'Order', 'Subscription' => 'financial',
            'Customer', 'AdminUser' => 'customer',
            'User', 'Role', 'Permission' => 'security',
            'Server', 'HostingAccount', 'DomainRegistration' => 'infrastructure',
            default => 'general',
        };
    }

    /**
     * Get additional metadata for audit logs.
     * Override this method in your models to provide custom metadata.
     */
    protected function getAuditMetadata(): array
    {
        return [];
    }

    /**
     * Manually log an audit event for this model.
     */
    public function audit(
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $severity = 'medium',
        array $metadata = null
    ): AuditLog {
        $auditService = app(AuditService::class);
        
        return $auditService->log(
            $this,
            $event,
            $actionDescription,
            $oldValues,
            $newValues,
            $this->getAuditCategory(),
            $severity,
            array_merge($this->getAuditMetadata(), $metadata ?? [])
        );
    }

    /**
     * Get recent audit logs for this model.
     */
    public function getRecentAuditLogs(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return $this->auditLogs()
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
