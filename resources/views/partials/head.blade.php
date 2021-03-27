<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @php wp_head() @endphp
  <script type="text/javascript">
    ymaps.ready(init);

    function init() {
      var myMap = new ymaps.Map('map', {
          center: [55.755273, 37.610454],
          zoom: 10,
          controls: ['geolocationControl', 'searchControl']
        }),
        deliveryPoint = new ymaps.GeoObject({
          geometry: {type: 'Point'},
          properties: {iconCaption: 'Адрес'}
        }, {
          preset: 'islands#blackDotIconWithCaption',
          draggable: true,
          iconCaptionMaxWidth: '215'
        }),
        searchControl = myMap.controls.get('searchControl');
      searchControl.options.set({noPlacemark: true, placeholderContent: 'Введите адрес доставки'});
      myMap.geoObjects.add(deliveryPoint);

      function onZonesLoad(json) {
        // Добавляем зоны на карту.
        var deliveryZones = ymaps.geoQuery(json).addToMap(myMap);
        // Задаём цвет и контент балунов полигонов.
        deliveryZones.each(function (obj) {
          obj.options.set({
            fillColor: obj.properties.get('fill'),
            fillOpacity: obj.properties.get('fill-opacity'),
            strokeColor: obj.properties.get('stroke'),
            strokeWidth: obj.properties.get('stroke-width'),
            strokeOpacity: obj.properties.get('stroke-opacity'),
            zoneNumber: obj.properties.get('zone-number')
          });
          obj.properties.set('balloonContent', obj.properties.get('description'));
        });

        // Проверим попадание результата поиска в одну из зон доставки.
        searchControl.events.add('resultshow', function (e) {
          highlightResult(searchControl.getResultsArray()[e.get('index')]);
        });

        // Проверим попадание метки геолокации в одну из зон доставки.
        myMap.controls.get('geolocationControl').events.add('locationchange', function (e) {
          highlightResult(e.get('geoObjects').get(0));
        });

        // При перемещении метки сбрасываем подпись, содержимое балуна и перекрашиваем метку.
        deliveryPoint.events.add('dragstart', function () {
          deliveryPoint.properties.set({iconCaption: '', balloonContent: ''});
          deliveryPoint.options.set('iconColor', 'black');
        });

        // По окончании перемещения метки вызываем функцию выделения зоны доставки.
        deliveryPoint.events.add('dragend', function () {
          highlightResult(deliveryPoint);
        });

        function highlightResult(obj) {
          // Сохраняем координаты переданного объекта.
          var coords = obj.geometry.getCoordinates(),
            // Находим полигон, в который входят переданные координаты.
            polygon = deliveryZones.searchContaining(coords).get(0);

          if (polygon) {
            // Уменьшаем прозрачность всех полигонов, кроме того, в который входят переданные координаты.
            deliveryZones.setOptions('fillOpacity', 0.4);
            polygon.options.set('fillOpacity', 0.8);
            // Перемещаем метку с подписью в переданные координаты и перекрашиваем её в цвет полигона.
            deliveryPoint.geometry.setCoordinates(coords);
            deliveryPoint.options.set('iconColor', polygon.properties.get('fill'));
            //let address = obj.properties._data.name;
            //document.getElementById('billing_address_1').value = address;
            let zone = polygon.options.get('zoneNumber');
            checkDelivery(zone);
            // Задаем подпись для метки.
            if (typeof(obj.getThoroughfare) === 'function') {
              setData(obj);
            } else {
              // Если вы не хотите, чтобы при каждом перемещении метки отправлялся запрос к геокодеру,
              // закомментируйте код ниже.
              // ymaps.geocode(coords, {results: 1}).then(function (res) {
              //   var obj = res.geoObjects.get(0);
              //   setData(obj);
              // });
            }
          } else {
            // Если переданные координаты не попадают в полигон, то задаём стандартную прозрачность полигонов.
            deliveryZones.setOptions('fillOpacity', 0.4);
            // Перемещаем метку по переданным координатам.
            deliveryPoint.geometry.setCoordinates(coords);
            // Задаём контент балуна и метки.
            deliveryPoint.properties.set({
              iconCaption: 'Адрес вне зоны доставки',
              balloonContent: 'Cвяжитесь с оператором',
              balloonContentHeader: ''
            });
            // Перекрашиваем метку в чёрный цвет.
            deliveryPoint.options.set('iconColor', 'black');
            checkDelivery(false)
          }

          function setData(obj){
            var address = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
            if (address.trim() === '') {
              address = obj.getAddressLine();
            }
            var price = polygon.properties.get('description');
            price = price.match(/<strong>(.+)<\/strong>/)[1];
            deliveryPoint.properties.set({
              iconCaption: address,
              balloonContent: address,
              balloonContentHeader: price
            });
          }
        }
      }

      jQuery.ajax({
        url: '/data.geojson',
        dataType: 'json',
        success: onZonesLoad
      });
    }

    function checkDelivery(zone) {
      let input = document.getElementById('billing_country');
      if (zone === 1) {
        input.value = 'ZN1';
        jQuery('#shipping_country').val('ZN1').trigger('change');
        jQuery('.order__pay-button').removeAttr('disabled')
      } else if ( zone === 2 ) {
        input.value = 'ZN2';
        jQuery('#shipping_country').val('ZN2').trigger('change');
        jQuery('.order__pay-button').removeAttr('disabled')
      } else {
        input.value = 'RU';
        jQuery('#shipping_country').val(null).trigger('change');
        jQuery('.order__pay-button').attr('disabled', 'disabled')
      }
      jQuery('body').trigger('update_checkout');
    }
  </script>
</head>
