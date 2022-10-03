# Code refactoring

- run tests `docker compose exec php composer test`
- run app `docker compose exec php php ./public/app.php ./public/input.txt`

# Original code does not work

rate source `https://api.exchangeratesapi.io/latest` requires access_key, which makes it not possible to get the original results for future comparing.
``` json
{
    "success": false,
    "error": {
        "code": 101,
        "type": "missing_access_key",
        "info": "You have not supplied an API Access Key. [Required format: access_key=YOUR_ACCESS_KEY]"
    }
}
```

# Changes

## Invalid exchange rate
I added exception in case api is not responding.

``` php
if ($rate <= 0) {
throw new InvalidArgumentException('Invalid exchange rate.');
}
```

## Exchange rate api
As exchange api is not working, I added fake json in tests.

## Todo
Add ceiling of commissions.

Expand tests by covering:
* invalid exchange rate
* different transaction dto
* modifiers tests
