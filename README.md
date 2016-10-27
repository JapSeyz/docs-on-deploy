# Installation instructions
* Download [ARToolkit](https://artoolkit.org/documentation/doku.php?id=1_Getting_Started:about_installing)
    * Extract ```tar xzvf ARToolKit5-bin-*.tar.gz```
    * Run ```./share/artoolkit5-setenv```
    * Copy ```genTexData``` to /bin

 * Install the package via Composer ```composer require japseyz/ar-toolkit```
 * Add ```JapSeyz\Ar\ToolkitServiceProvider::class,``` to providers      
    
    
    

## Usage

``` php
$toolkit = new JapSeyz\Ar\Toolkit();
$toolkit->add($pathToJpgImage);
$toolkit->queue($pathToJpgImage);
```
