# For recursively masking secret data  within array-values.

For recursively (deep) masking secret data within array-values.

## Install

```console
$ composer require youhey/array-values-masking
```

## Testing

```console
$ composer test
```

or

```console
# set up Docker images for php 7.2
$ docker build -t youhey/php72-array-values-masking docker/php72

# set up Docker images for php 7.1
$ docker build -t youhey/php71-array-values-masking docker/php71

# set up Docker images for php 7.0
$ docker build -t youhey/php70-array-values-masking docker/php70

# composer install
$ docker run --rm -v "$(pwd):/work" youhey/php72-array-values-masking composer install
# or docker run --rm -v "$(pwd):/work" youhey/php71-array-values-masking composer install
# or docker run --rm -v "$(pwd):/work" youhey/php70-array-values-masking composer install

# to run tests
$ docker run --rm -v "$(pwd):/work" youhey/php72-array-values-masking composer test
# or docker run --rm -v "$(pwd):/work" youhey/php71-array-values-masking composer test
# or docker run --rm -v "$(pwd):/work" youhey/php70-array-values-masking composer test
```
