<?php
return;

trait Masteryl_Mailer_Personalize
{
  
  /**
   * custom email before sending it
   *
   * @param array or false of custom fields
   * @param boolean $prefix
   * @return void
   */
  public function personalize($personalizations = false, $prefix = false)
  {
    if(!$personalizations) $personalizations = $this->personalizations;

    $email = json_encode($this->email);

    foreach($personalizations as $name => $fields) {     

        foreach ($fields as $field) {

          if($prefix) $key = gettype($prefix) == 'string' ? "{$prefix}.{$field}" : "{$name}.{$field}";
          else $key = $field;
        
          $pattern = '/(\{)(\s){0,1}('.$key.')(\s){0,1}(\})/';
          $value = !empty($this->{$name}) && !empty($this->{$name}->{$field}) ? $this->{$name}->{$field} : $def;
          $email = preg_replace($pattern, $value, $email);
        }

    }

    $email = json_decode($email);

    foreach($this->email_personalizations as $i)
    if(isset($email->{$i})) $this->email->{$i} = $email->{$i};
 

  }

}