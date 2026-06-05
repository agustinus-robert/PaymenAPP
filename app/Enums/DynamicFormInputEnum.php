<?php

namespace App\Enums;

enum DynamicFormInputEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';
    case RANGE = 'range';
    case DESCRIPTION = 'description';

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Jawaban singkat',
            self::NUMBER => 'Angka/nomor',
            self::TEXTAREA => 'Jawaban panjang',
            self::SELECT => 'Drop-down',
            self::CHECKBOX => 'Kotak centang',
            self::RADIO => 'Pilihan ganda',
            self::RANGE => 'Slider',
            self::DESCRIPTION => 'Isian kesan dan saran',
        };
    }

    /**
     * Get the html accessor with html() object
     */
    public function html($field): string
    {
        return match ($this) {
            self::TEXT => '<input type="text"/>',
            self::NUMBER => '<input type="number"/>',
            self::TEXTAREA => '<textarea></textarea>',
            self::SELECT => '<select></select>',
            self::CHECKBOX => '<input type="checkbox"/>',
            self::RADIO => '<input type="radio"/>',
            self::RANGE => '<input type="range"/>',
            self::DESCRIPTION => '<textarea></textarea>',
        };
    }
}
