<?php

trait Masteryl_Template_Loaders
{
    private function loadPartials($file)
    {
        $regex = '/({{)(::)(.*)(}})/';

        if (preg_match($regex, $this->_contents)) {
            preg_replace_callback($regex, [$this, 'loadSnippet'], $this->_contents);
        }
    }

    private function loadSnippet($data)
    {
        preg_match('/(?<={{::)(.*)(?=}})/', $data[0], $matches, PREG_UNMATCHED_AS_NULL);

        $file = $this->path . $matches[0] . '.php';

        if (!file_exists($file)) {
            exit('Error: Template partial not found: ' . $file);
        }

        $snippet = file_get_contents($file);

        $this->_contents = str_replace($data[0], $snippet, $this->_contents);
    }

    private function loadLayout($tpl)
    {
        if (!preg_match($this->layouts_regex, $tpl)) {
            return $tpl;
        }

        $this->layout_tpl = $tpl;

        preg_replace_callback($this->layouts_regex, [$this, 'extendLayout'], $tpl);

        return $this->layout_tpl;
    }
}
