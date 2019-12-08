# CakePHP trailing slash URLs

Add trailing slash to CakePHP Url helper and controller redirect method. Check if the URL have trailing slash and if not add it.

## Install
- Copy `config > functions.php` in your **config** folder.
- Copy `src > View > Helper > TrailingSlashUrlHelper.php` file in your **Helper** folder.

### Requirements
- PHP >= 7.1.x
- CakePHP >= 3.6.x

### Include in bootstrap.php
Include `functions.php` file in `config > bootstrap.php` before `use` statements.
```php
/*
 * New functions
 */
require __DIR__ . DS . 'functions.php';

//use ...
```

### Put in AppController
Copy `beforeFilter` (Check trailing slash) and `redirect` method in `src > Controller > AppController.php` file. Your controllers need to extend the `AppController` if you want to access the new `redirect` method with trailing slash.
```php
use Cake\Event\Event;
use Cake\Routing\Router;

class AppController extends Controller
{
    // What you already have

    /**
     * @inheritdoc
     * @param Event $event Event
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        // ...

        // Check trailing slash
        $pageURL = $this->getRequest()->getRequestTarget();
        if (!pathinfo($pageURL, PATHINFO_EXTENSION)
            && strpos($pageURL, '#') === false
            && strpos($pageURL, '?') === false
            && substr($pageURL, -1) != DS
        ) {
            return $this->redirect($pageURL, 301);
        }

        // ...
    }

    /**
     * @inheritdoc
     * @param array|string $url Redirect URL
     * @param bool $status Redirect status code
     * @return \Cake\Http\Response|null
     */
    public function redirect($url, $status = 302)
    {
        $url = Router::url($url);
        $url = trailing_slash_url($url);

        return parent::redirect($url, $status);
    }

    // What you already have
}
```

### Load in AppView
Load and override **Url** helper with **TrailingSlashUrl** helper in `src > View > AppView.php` in `initialize` method like below.
```php
/**
 * @property \App\View\Helper\TrailingSlashUrlHelper $Url
 */
class AppView extends View
{
    public function initialize()
    {
        // ...
        $this->loadHelper('Url', ['className' => 'TrailingSlashUrl']);
        // ...
    }
}
```

## Example
In controller:
```php
class TestController extends AppController
{
    public static index()
    {
        return $this->redirect(['_name' => 'testRoute'], 301);
    }
}
```

In template:
```php
echo $this->Url->build('/test'); // Output: /test/
echo $this->Url->build(['_name' => 'testRoute']); // Output: /test/

echo $this->Html->link('Click here',  '/test', ['target' => '_blank']); // HTML Output: <a href="/test/" target="_blank">Click here</a>
```

Enjoy ;)
