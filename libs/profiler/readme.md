# PHP Profiler
###### German Documentation

### The project was originally just an exercise. I am making it public anyway

-------------------------------------------------------------------

## Installation
Downloade das Archiv und lade es auf deinen Webserver. Binde es dann mit folgendem Befehl ein.

```php
use Profiler\Profiler;
require 'path/to/autoload.php';
```

-------------------------------------------------------------------

## Laufzeit Aufnehmen
nehme die laufzeit eines gewissen code teils auf
```php

$profiler = new Profiler;

$profiler->rec('section');

// My Code

$profiler->stop('section');

```

du kannst die Methoden auch verketten

```php
$profiler->rec('all')->rec('firstSection');

// first section code

$profiler->stop('firstSection')->rec('secondSection');

// second section code

$profiler->stop('secondSection')->stop('all');
```

-------------------------------------------------------------------

## SERVER_REQUEST_TIME
wenn der constructor von Profiler aufgerufen wird, wird automatisch auch die Laufzeit der Server Request Zeit aufgenommen
diese muss dann nur noch gestoppt werden

```php

$profiler = new Profiler;

//my code

$profiler->stop(Profiler::SERVER_REQUEST_TIME);

```

-------------------------------------------------------------------

## Ergebnisse ausgeben

der Profiler erstellt einen Dump aller ProfilerElemente und gibt sie in einem Iterator aus

```php

$times = $profiler->dump();

foreach($times as $time) {
    echo $time->getName() . ': ';
    echo $time->getExecTime() . '<br />';
}

```
der Dump kann auch reversed werden

```php
$times = $profiler->dump(true);
```