# Thumbnail On Demand

- [EN](#en)
- [FR](#fr)

## EN

Thumbnail On Demand is a WordPress plugin designed to better control image thumbnail generation and generate them on-the-fly. This plugin optimizes the management of thumbnails by generating only those that are truly necessary, thus reducing server resource consumption and storage space usage.

### How it works

The plugin intercepts thumbnail requests for images and generates the required sizes on-the-fly if they don't already exist. It also allows you to define your own image resizing class by implementing the ImageResizerInterface and defining the IMAGE_RESIZER_CLASS constant.

#### Customizing the image resizing class

To use your own image resizing class, define the `IMAGE_RESIZER_CLASS` constant in your `wp-config.php` file or in a custom plugin:

```php
define('IMAGE_RESIZER_CLASS', 'MyCustomImageResizer');
```

Your custom class should implement the `AmphiBee\ThumbnailOnDemand\Contracts\ImageResizerInterface` and define the `resize()` method.

#### Available filters

The plugin provides two filters to customize the automatically generated thumbnail sizes.

`tod/include_thumbnail_sizes` This filter allows you to include specific thumbnail sizes that will be automatically generated when an image is uploaded. By default, no sizes are included.

##### Example usage:

```php
add_filter('tod/include_thumbnail_sizes', function ($sizes) {
return ['medium', 'large'];
});
```

`tod/exclude_thumbnail_sizes` This filter allows you to exclude specific thumbnail sizes that will not be automatically generated when an image is uploaded. By default, all registered sizes are excluded.

##### Example usage:

```php
add_filter('tod/exclude_thumbnail_sizes', function ($sizes) {
return ['small', 'thumbnail'];
});
```

### License
The Thumbnail On Demand plugin is released under the GPL-3.0-or-later license.

## FR

Thumbnail On Demand est une extension WordPress permettant de mieux contrôler la génération de miniatures d'images et de les générer à la volée. Cette extension optimise la gestion des miniatures en ne générant que celles qui sont réellement nécessaires, réduisant ainsi la consommation de ressources serveur et d'espace de stockage.

### Fonctionnement
 L'extension intercepte les demandes de miniatures pour les images et génère les tailles requises à la volée si elles n'existent pas déjà. Elle permet également de définir sa propre classe de redimensionnement d'image en implémentant l'interface ImageResizerInterface et en définissant la constante IMAGE_RESIZER_CLASS.

#### Personnaliser la classe de redimensionnement d'image
Pour utiliser votre propre classe de redimensionnement d'image, définissez la constante `IMAGE_RESIZER_CLASS` dans votre fichier `wp-config.php` ou dans un plugin personnalisé :

```php
define('IMAGE_RESIZER_CLASS', 'MyCustomImageResizer');
```

Votre classe personnalisée doit implémenter l'interface `AmphiBee\ThumbnailOnDemand\Contracts\ImageResizerInterface` et définir la méthode `resize()`.


#### Filtres disponibles
L'extension met à disposition deux filtres pour personnaliser les tailles de miniatures générées automatiquement.

`tod/include_thumbnail_sizes` Ce filtre vous permet d'inclure des tailles de miniatures spécifiques qui seront générées automatiquement lors de l'upload d'une image. Par défaut, aucune taille n'est incluse.

##### Exemple d'utilisation :

```php
add_filter('tod/include_thumbnail_sizes', function ($sizes) {
return ['medium', 'large'];
});
```

`tod/exclude_thumbnail_sizes` Ce filtre vous permet d'exclure des tailles de miniatures spécifiques qui ne seront pas générées automatiquement lors de l'upload d'une image. Par défaut, toutes les tailles enregistrées sont exclues.

##### Exemple d'utilisation :

```php
add_filter('tod/exclude_thumbnail_sizes', function ($sizes) {
return ['small', 'thumbnail'];
});
```

### Licence
L'extension Thumbnail On Demand est publiée sous licence GPL-3.0-or-later.