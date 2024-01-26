<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DifficultyIcon extends Component
{
    private string $iconName;
    private string $altText;
    private string $class;
    /**
     * Create a new component instance.
     */
    public function __construct(float $eyupStars, int $mode, string $class = '')
    {
        if($eyupStars >= 0 && $eyupStars < 2.7) {
            $this->iconName = "easy" . $mode . ".png";
            $this->altText = "easy";
        } else if($eyupStars > 2.7 && $eyupStars <= 3.7) {
            $this->iconName = "normal" . $mode . ".png";
            $this->altText = "normal";
        } else if($eyupStars > 3.7 && $eyupStars <= 4.5) {
            $this->iconName = "hard" . $mode . ".png";
            $this->altText = "hard";
        } else {
            $this->iconName = "insane" . $mode . ".png";
            $this->altText = "insane";
        }

        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.difficulty-icon', [
            "icon" => $this->iconName,
            "alt" => $this->altText,
            "class" => $this->class
        ]);
    }
}
