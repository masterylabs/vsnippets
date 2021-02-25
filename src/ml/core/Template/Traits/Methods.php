<?php
trait Masteryl_Template_Methods
{
    public function assign($a, $val = '')
    {
        if (is_array($a)) {
            foreach ($a as $key => $val) {
                $this->assignedAtts[$key] = $val;
            }
        } else {
            $this->assignedAtts[$a] = $val;
        }

        // ee($this->assignedAtts);
        // echo ', $key ' . $key;
    }

    public function get()
    {
        return $this->show(true);
    }

    public function show($get = false)
    {
        $contents = $this->_contents;

        if (count($this->assignedAtts) > 0) {

            // verables {{ value }}
            $regex = '/({{)[0-9a-zA-Z\s]*(}})/';

            foreach ($this->assignedAtts as $key => $val) {
                if (is_string($val))
                $contents = preg_replace('/({{)(\s){0,1}' . $key . '(\s){0,1}(}})/', $val, $contents);
                
              

                $$key = $val;
            }
        }

        // fix paths

        if (preg_match('/="public::/', $contents, $value)) {
            $contents = preg_replace('/="public::/', '="' . $this->public_url . '/', $contents);
        }

        $contents = preg_replace('/="public::/', $this->public_url . '/', $contents);
   

        if ($get) {
            return $contents;
        }

        return eval('?>' . $contents); // <?php;

        exit;
    }
}
