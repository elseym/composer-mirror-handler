# Composer Mirror Handler

## usage

in your composer.json, require this package:

```json
"require": {
    "elseym/mirror-handler": "~1.0"
}
```

then add the script hooks:

```json
"scripts": {
    "post-install-cmd": [ "Elseym\\MirrorHandler\\Mirror::handle" ],
    "post-update-cmd": [ "Elseym\\MirrorHandler\\Mirror::handle" ]
}
```

finally, define which dependencies should be mirrored where:

```json
"extra": {
    "mirror": {
        "vendor23/package-foo": "Library/FooPackage",
        "vendor42/bar-package": "Library/PackageBar"
    }
}
```
