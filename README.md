# magento-restextended

This is a Magento 1.9/OpenMage extension that aims to provide a full REST API implementation. It's also fully compatible with my other [HTTP Basic Authentication extension](https://github.com/elidrissidev/magento-api2basicauth).

**:construction: This extension is still in development! :construction:**

## Installation

### Manual

1. Download the latest release and unpack it.

2. Copy the `app` folder to the root of your magento store (choose the option to merge it with the existing files if prompted).

3. Go to `System / Cache Management` and flush "Configuration" and "Web Services Configuration" cache.

### Composer

For OpenMage users, you can install this package easily by using composer:

```sh
$ composer require elidrissidev/magento-restextended
```

## Features

This extension adds the following endpoints to the REST API:

- `POST /api/rest/orders/:id/comments` - Add a comment to an Order.
- `GET /api/rest/orders/comments/:id` - Retrieve Order comment by id

*NOTE: Be sure to grant the necessary permissions to your REST Role.*

## Contributing

Please feel free to open an Issue if you find any bug, or have something to suggest.

## License

This project is licensed under the [MIT License](LICENSE).
