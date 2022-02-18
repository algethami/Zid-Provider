# Zid Provider

```bash
composer require algethami/zid-provider
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

```php
'zid' => [
    'client_id' => env('ZID_CLIENT_ID'),
    'client_secret' => env('ZID_CLIENT_SECRET'),
    'redirect' => env('ZID_REDIRECT_URI')
]
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('zid')->redirect();
```

### Returned User fields

- ``id``
- ``nickname``
- ``name``
- ``email``