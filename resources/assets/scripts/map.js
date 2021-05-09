ymaps.ready(init);
function init() {
  var myMap = new ymaps.Map('map', {
      center: [53.222669, 50.207144],
      zoom: 11,
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
  searchControl.options.set({
    noPlacemark: true,
    placeholderContent: 'Введите адрес доставки',
    noSelect: true
  });
  searchControl.events.add('load', function (event) {
    // Проверяет, что это событие не "дозагрузка" результатов и
    // по запросу найден хотя бы один результат.
    if (!event.get('skip') && searchControl.getResultsCount()) {
      searchControl.showResult(0);
    }
  });
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
        let address = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
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
        //console.log(obj.properties._data);
        // Задаем подпись для метки.
        if (typeof (obj.getThoroughfare) === 'function') {
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

      function setData(obj) {
        var address = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
        if (address.trim() === '') {
          address = obj.getAddressLine();
        }
        //console.log(address);
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


  const token = '7ddfb736edd271b94a75fafbcb6844e6bdc77121';
  function checkDelivery(zone) {
    jQuery('woocommerce-terms-and-conditions-checkbox-text').text('zone: ' + zone);
    let input = document.getElementById('billing_country');
    if (zone === 1 || zone === 2 || zone === 3 || zone === 4) {
      input.value = `ZN${zone}`;
      jQuery('#shipping_country').val(`ZN${zone}`).trigger('change');
    } else {
      input.value = 'RU';
      jQuery('#shipping_country').val(null).trigger('change');
    }
    jQuery('body').trigger('update_checkout');
  }
  jQuery('#billing_address_1').suggestions({
    token: token,
    type: 'ADDRESS',
    constraints: {
      locations: { city: 'Самара' },
    },
    /* Вызывается, когда пользователь выбирает одну из подсказок */
    onSelect: function(suggestion) {
      searchControl.search(suggestion.value);
      jQuery('body').trigger('update_checkout');
    },
  });
}

