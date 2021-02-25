<?php
trait Masteryl_Template_ExtendLayout
{
    private function extendLayout($m)
    {
        // get layout
        $regex = '[(?<=\()[0-9a-zA-Z\s\.\/]*]';
        preg_match($regex, $m[0], $v);
        $file = $this->path . $v[0] . '.php';

        if (!file_exists($file)) {
            exit('Error: Template extends not found: ' . $file);
        }

        $layout = file_get_contents($file);

        // yields
        preg_match_all('[(?<=@:)([\s\S]*?)(?=\s*\(\))]', $layout, $slots);

        $slots = $slots[0];

        $tpl = $this->layout_tpl;

        if (!empty($slots)) {
            foreach ($slots as $slot) {
                $regex = "[(?<=@:start\({$slot}\))([\s\S]*?)(?=\s*\@:end\({$slot}\))]";
                preg_match_all($regex, $tpl, $blocks);
                $blocks = $blocks[0];

                $layout = str_replace("@:{$slot}()", $blocks[0], $layout);
            }
        }

        $this->layout_tpl = $layout;
    }
}
