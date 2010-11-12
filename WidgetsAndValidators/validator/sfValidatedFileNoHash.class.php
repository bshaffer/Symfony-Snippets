<?php

/**
* Pass this classname in as the "validated_file_class" option to sfValidatorFile to 
* preserve the uploaded file's original filename.
*/
class sfValidatedFileNoHash extends sfValidatedFile
{
  public function generateFilename()
  {
    return $this->getOriginalName();
  }
}
