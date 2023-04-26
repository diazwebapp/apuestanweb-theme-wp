# documentación

## Bookmmaker Shortcodes

### [bookmakers]

![imagen](doc/shortcodes/bookmakers/model_1.png)

| parámetros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| num        | numero de items a mostrar                                                  |
| model      | debe ser numérico                                                          |
| country    | codigo alfabetico del pais, ejemplo UK,CO,EU |

### [banner_bookmaker]

![imagen](doc/shortcodes/banner_bookmaker/model_1.png)

| parámetros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| id         | id del bookmaker,se selecciona automaticamente si se pinta en un single bk |

### [banner_bookmaker_payment_methods]

![imagen](doc/shortcodes/banner_bookmaker_payment_methods/Screenshot_2023-03-05_16-22-35.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| id         | id del bookmaker,se selecciona automaticamente si se pinta en un single bk |

### [slide_bk]

![imagen](doc/shortcodes/slide_bk/model_1.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| title      | titulo del shortcode |
| slogan     | slogan del shortcode |
| model      | numérico 1,2,3       |

![imagen](doc/shortcodes/slide_bk/model_2.png)
![imagen](doc/shortcodes/slide_bk/model_3.png)

## forecast shortcodes

### [forecasts]

#### model 1

![imagen](doc/shortcodes/forecasts/model_1.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| num        | items por página |
| league     | lo toma automaticamnete de la pagina donde se usa, o string all si desea mostrar todos los deportes y ligas |
| model      | numérico 1,2,3       |
| text_vip_link | texto que se mostrará en el boton de vip |
| filter     | string "yes", activa el filtro de fechas |
| title      | titulo del shortcode |
| date       | mustra los eventos segudel dia indicado, ayer, hoy o mañana |
| time_format | string "count", activa conteo regresivo de los eventos |

#### model 2

![imagen](doc/shortcodes/forecasts/model_2.png)

#### model 3

![imagen](doc/shortcodes/forecasts/model_3.png)

#### model 4

![imagen](doc/shortcodes/forecasts/model_4.png)

### [forecasts_vip]

#### model 1

![imagen](doc/shortcodes/forecasts_vip/model_1_locked.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| num        | items por página |
| league     | lo toma automaticamnete de la pagina donde se usa, o string all si desea mostrar todos los deportes y ligas |
| model      | numérico 1,2,3       |
| text_vip_link | texto que se mostrará en el boton de vip |
| filter     | string "yes", activa el filtro de fechas |
| title      | titulo del shortcode |
| date       | mustra los eventos segudel dia indicado, ayer, hoy o mañana |
| time_format | string "count", activa conteo regresivo de los eventos |
| unlock     | string "yes", muestra los eventos vip desbloqueados, default "locked" |

#### model 1 unlocked

![imagen](doc/shortcodes/forecasts_vip/model_1_unlock.png)

## parley shortcodes

### [parley]

![imagen](doc/shortcodes/parley/model_1.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| num        | items por página |
| league     | lo toma automaticamnete de la pagina donde se usa, o string all si desea mostrar todos los deportes y ligas |
| model      | numérico 1,2,3       |
| text_vip_link | texto que se mostrará en el boton de vip |
| filter     | string "yes", activa el filtro de fechas |
| title      | titulo del shortcode |
| date       | mustra los eventos segudel dia indicado, ayer, hoy o mañana |

### [parley_vip]

![imagen](doc/shortcodes/parley_vip/model_1_locked.png)

#### unlocked

![imagen](doc/shortcodes/parley_vip/model_1_unlock.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| num        | items por página |
| league     | lo toma automaticamnete de la pagina donde se usa, o string all si desea mostrar todos los deportes y ligas |
| model      | numérico 1,2,3       |
| text_vip_link | texto que se mostrará en el boton de vip |
| filter     | string "yes", activa el filtro de fechas |
| title      | titulo del shortcode |
| date       | mustra los eventos segudel dia indicado, ayer, hoy o mañana |
| unlock     | string "yes", muestra los eventos vip desbloqueados, default "locked" |

## Predicciones

### [predictions]

![imagen](doc/shortcodes/predictions/model_1.png)

| parametros | detalle                                                                    |
|------------|----------------------------------------------------------------------------|
| id         | id del pronostico, si se usa en un pronostico, lo toma automaticamente |