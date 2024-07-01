
# Chiamate API
#### ctrl + click su percorso per test

## Endpoints for restaurants

```bash

# Ottieni tutti i ristoranti (paginati)
http://127.0.0.1:8000/api/get-restaurants

# Ottieni tutti i ristoranti della tipologia specificata (paginati)
http://127.0.0.1:8000/api/get-restaurants?typology=cinese

# ottieni tutti i ristoranti di tipo cinese OPPURE pesce (paginati)
http://127.0.0.1:8000/api/get-restaurants?typology=cinese,pesce 

# ottieni tutti i ristoranti di tipo cinese E pesce (paginati)
http://127.0.0.1:8000/api/get-restaurants?typology=cinese,pesce&match=all

# ottieni tutti i ristoranti di un certo utente (user-slug) (paginati)
http://127.0.0.1:8000/api/get-restaurants?user-slug=tonino-marino

# ottieni uno specifico ristorante (restaurant-slug)
http://127.0.0.1:8000/api/get-restaurants/ristorante-onisto

```
## Endpoints for dishes

```bash
# Ottieni tutti i piatti (VISIBILI) nel db (paginati)
http://127.0.0.1:8000/api/get-dishes

# Ottieni tutti i piatti (INCLUSI I NON VISIBILI) nel db (paginati)
http://127.0.0.1:8000/api/get-dishes?visible=all

# Ottieni tutti i piatti (VISIBILI)  di un ristorante (restaurant-slug)
http://127.0.0.1:8000/api/get-dishes?restaurant-slug=ristorante-onisto

# Ottieni tutti i piatti (INCLUSI I NON VISIBILI) di un ristorante (restaurant-slug)
http://127.0.0.1:8000/api/get-dishes?restaurant-slug=ristorante-onisto&visible=all

# ottieni i dettagli di uno specifico piatto (dish-slug)
http://127.0.0.1:8000/api/get-dishes/ristorante-onisto-noodles-alla-pechinese


```


## Endpoints for Orders

```bash
# Ottieni tutti gli ordini nel nel db (paginati) [con dish, e quantità]
http://127.0.0.1:8000/api/get-orders

# Ottieni tutti i dettagli di un ordine specifico passando lo slug (ristorante-altera-order-1) [con dish, e quantità]
http://127.0.0.1:8000/api/get-orders/ristorante-altera-order-1


```


## Endpoints for Orders

```bash
# Ottieni tutte le tipologie nel nel db con i ristoranti
http://127.0.0.1:8000/api/get-typologies


```

