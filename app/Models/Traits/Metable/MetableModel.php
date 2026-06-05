<?php

namespace App\Models\Traits\Metable;

use App\Models\Traits\Metable\DataType;
use App\Models\Traits\Metable\DataType\Registry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetableModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $guarded = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'type' => 'string',
        'value' => '',
    ];

    /**
     * Cache of unserialized value.
     *
     * @var mixed
     */
    protected $cachedValue;

    /**
     * Metable Relation.
     *
     * @return BelongsTo
     */
    public function metable(): BelongsTo
    {
        return $this->belongsTo();
    }

    /**
     * Accessor for value.
     *
     * Will unserialize the value before returning it.
     *
     * Successive access will be loaded from cache.
     *
     * @return mixed
     * @throws Exceptions\DataTypeException
     */
    public function getValueAttribute()
    {
        if (!isset($this->cachedValue)) {
            $this->cachedValue = $this->getDataTypeRegistry()
                ->getHandlerForType($this->type)
                ->unserializeValue($this->attributes['value']);
        }

        return $this->cachedValue;
    }

    /**
     * Mutator for value.
     *
     * The `type` attribute will be automatically updated to match the datatype of the input.
     *
     * @param mixed $value
     * @throws Exceptions\DataTypeException
     */
    public function setValueAttribute($value): void
    {
        $registry = $this->getDataTypeRegistry();

        $this->attributes['type'] = $registry->getTypeForValue($value);
        $this->attributes['value'] = $registry->getHandlerForType($this->type)
            ->serializeValue($value);

        $this->cachedValue = null;
    }

    /**
     * Retrieve the underlying serialized value.
     *
     * @return string
     */
    public function getRawValue(): string
    {
        return $this->attributes['value'];
    }

    /**
     * Get the datatypes.
     *
     * @return Registry
     */
    protected function getDataTypes()
    {
        return [
            DataType\BooleanHandler::class,
            DataType\NullHandler::class,
            DataType\IntegerHandler::class,
            DataType\FloatHandler::class,
            DataType\StringHandler::class,
            DataType\DateTimeHandler::class,
            DataType\ArrayHandler::class,
            DataType\ModelHandler::class,
            DataType\ModelCollectionHandler::class,
            DataType\SerializableHandler::class,
            DataType\ObjectHandler::class,
        ];
    }

    /**
     * Load the datatype Registry from the container.
     *
     * @return Registry
     */
    protected function getDataTypeRegistry(): Registry
    {
        $registry = new Registry();
        foreach ($this->getDataTypes() as $handler) {
            $registry->addHandler(new $handler());
        }

        return $registry;
    }
}
