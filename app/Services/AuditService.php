<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log an audit event.
     */
    public function log(
        Model $model,
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $category = 'general',
        string $severity = 'medium',
        array $metadata = null,
        User $user = null,
        Request $request = null
    ): AuditLog {
        // Get current user if not provided
        if (!$user) {
            $user = Auth::user();
        }

        // Get request context if available
        $ipAddress = null;
        $userAgent = null;
        
        if ($request) {
            $ipAddress = $request->ip();
            $userAgent = $request->userAgent();
        } elseif (request()) {
            $ipAddress = request()->ip();
            $userAgent = request()->userAgent();
        }

        return AuditLog::create([
            'user_id' => $user?->id,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'event' => $event,
            'action_description' => $actionDescription,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'metadata' => $metadata,
            'category' => $category,
            'severity' => $severity,
        ]);
    }

    /**
     * Log a financial transaction.
     */
    public function logFinancial(
        Model $model,
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $severity = 'high',
        array $metadata = null
    ): AuditLog {
        return $this->log(
            $model,
            $event,
            $actionDescription,
            $oldValues,
            $newValues,
            'financial',
            $severity,
            $metadata
        );
    }

    /**
     * Log a customer-related action.
     */
    public function logCustomer(
        Model $model,
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $severity = 'medium',
        array $metadata = null
    ): AuditLog {
        return $this->log(
            $model,
            $event,
            $actionDescription,
            $oldValues,
            $newValues,
            'customer',
            $severity,
            $metadata
        );
    }

    /**
     * Log a system-level action.
     */
    public function logSystem(
        Model $model,
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $severity = 'medium',
        array $metadata = null
    ): AuditLog {
        return $this->log(
            $model,
            $event,
            $actionDescription,
            $oldValues,
            $newValues,
            'system',
            $severity,
            $metadata
        );
    }

    /**
     * Log a security-related action.
     */
    public function logSecurity(
        Model $model,
        string $event,
        string $actionDescription,
        array $oldValues = null,
        array $newValues = null,
        string $severity = 'critical',
        array $metadata = null
    ): AuditLog {
        return $this->log(
            $model,
            $event,
            $actionDescription,
            $oldValues,
            $newValues,
            'security',
            $severity,
            $metadata
        );
    }

    /**
     * Log model creation.
     */
    public function logCreated(Model $model, string $category = 'general', array $metadata = null): AuditLog
    {
        $modelName = class_basename($model);
        
        return $this->log(
            $model,
            'created',
            "{$modelName} created",
            null,
            $model->toArray(),
            $category,
            $this->getSeverityForEvent('created', $category),
            $metadata
        );
    }

    /**
     * Log model update.
     */
    public function logUpdated(Model $model, array $oldValues, string $category = 'general', array $metadata = null): AuditLog
    {
        $modelName = class_basename($model);
        
        return $this->log(
            $model,
            'updated',
            "{$modelName} updated",
            $oldValues,
            $model->toArray(),
            $category,
            $this->getSeverityForEvent('updated', $category),
            $metadata
        );
    }

    /**
     * Log model deletion.
     */
    public function logDeleted(Model $model, string $category = 'general', array $metadata = null): AuditLog
    {
        $modelName = class_basename($model);
        
        return $this->log(
            $model,
            'deleted',
            "{$modelName} deleted",
            $model->toArray(),
            null,
            $category,
            $this->getSeverityForEvent('deleted', $category),
            $metadata
        );
    }

    /**
     * Get appropriate severity for an event and category.
     */
    private function getSeverityForEvent(string $event, string $category): string
    {
        // Financial operations are always high severity
        if ($category === 'financial') {
            return 'high';
        }

        // Security operations are always critical
        if ($category === 'security') {
            return 'critical';
        }

        // Customer operations
        if ($category === 'customer') {
            return match($event) {
                'deleted' => 'high',
                'created', 'updated' => 'medium',
                default => 'medium',
            };
        }

        // Default severity mapping
        return match($event) {
            'deleted' => 'medium',
            'created', 'updated' => 'low',
            default => 'medium',
        };
    }

    /**
     * Get audit logs for a specific model.
     */
    public function getLogsForModel(Model $model, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::forModel($model)
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent critical audit logs.
     */
    public function getRecentCriticalLogs(int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::critical()
            ->with(['user', 'auditable'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get financial audit logs.
     */
    public function getFinancialLogs(int $limit = 100): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::financial()
            ->with(['user', 'auditable'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
