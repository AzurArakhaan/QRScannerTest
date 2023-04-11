<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#2196f3">
    <title>Главный экран</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="pwa/manifest.json">
</head>
<body class="bg-dark">
<div class="container h-100" id="app">
    <div class="row h-100 justify-content-center align-content-center my-auto">
        <div class="col-12">
            <div class="event-container card" id="card-picker">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 v-if="selectedEvent == null">Мероприятия</h3>
                    <h3 v-else>{{selectedEventName}}</h3>
                    <small @click="logOut">Выйти</small>
                </div>
                <transition name="fade" mode="out-in">
                    <div key="1" class="card-body bg-dark-subtle" v-if="selectedEvent == null">
                        <div class="card mb-2 p-2" @click="selectedEvent = event.id" v-for="event in events">
                            <h4>{{event.name}}</h4>
                            <p>{{event.description}}</p>
                        </div>
                    </div>
                    <div key="2" class="card-body bg-dark-subtle h-50" v-else>
                        <div class="card bg-white p-2">
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <button class="btn btn-dark" @click="selectedEvent = null">Назад</button>
                                <select class="form-control ml-3" name="cameraType" id="cameraType" v-model="cameraType">
                                    <option value="front">Фронтальная</option>
                                    <option value="rear">Задняя</option>
                                </select>
                            </div>
                            <div class="scanner-container mb-2">
                                <qrcode-stream :camera="cameraType" @init="onInit" @decode="decodeTrigger" :track="paintBoundingBox"></qrcode-stream>
                            </div>
                            <small class="text-danger" v-if="errorMessage != null">{{errorMessage}}</small>
                            <div class="scanner-results mb-2">
                                <p class="mb-1" v-for="result in scannerResults">{{result}}</p>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/index.js"></script>
<script src="assets/js/jquery-3.6.4.min.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/VueQrcodeReader.umd.min.js"></script>
<script>
    let vue = new Vue({
        el: '#app',
        data: {
            events: [],
            scannerResults: [],

            selectedEvent: null,

            cameraType: 'front',
            errorMessage: null,
        },
        created() {
            this.getEvents();
        },
        computed: {
            selectedEventName()
            {
                if (this.selectedEvent == null) {
                    return null;
                }

                return this.events.find(event => event.id === this.selectedEvent).name;
            }
        },
        watch: {
            selectedEvent(newVal, oldVal) {
                if (newVal == null) {
                    this.scannerResults = [];
                }
            }
        },
        methods: {
            getEvents()
            {
                axios.get('/api/getEvents').then(response => {
                    this.events = JSON.parse(response.data);
                });
            },

            logOut()
            {
                axios.post('/api/logOut').then(response => {
                    document.location.href = '/';
                });
            },

            async onInit (promise) {
                // show loading indicator

                try {
                    const { capabilities } = await promise

                    // successfully initialized
                } catch (error) {
                    switch (error.name) {
                        case 'NotAllowedError':
                            this.errorMessage = 'У приложения нет доступа к камере.';
                            break;

                        case 'NotFoundError':
                            this.errorMessage = 'На устройстве нет подходящей камеры.';
                            break;

                        case 'NotSupportedError':
                            this.errorMessage = 'Ваше соединение не защищено. Сканнер недоступен.';
                            break;

                        case 'NotReadableError':
                            this.errorMessage = 'Камера уже используется. Пожалуйста, закройте другие приложения что могут использовать камеру и попробуйте снова.';
                            break;

                        case 'OverconstrainedError':
                            this.errorMessage = 'Выбранной камеры нет на устройстве. Попробуйте выбрать другую.';
                            break;

                        case 'StreamApiNotSupportedError':
                            this.errorMessage = 'Браузер не поддерживает сканирование QR-Кодов.';
                            break;

                        default:
                            this.errorMessage = 'Произошла непредвиденная ошибка. Попробуйте позже.';
                            break;
                    }
                } finally {
                    this.errorMessage = null;
                }
            },
            paintBoundingBox (detectedCodes, ctx) {
                for (const detectedCode of detectedCodes) {
                    const { boundingBox: { x, y, width, height } } = detectedCode

                    ctx.lineWidth = 2
                    ctx.strokeStyle = '#007bff'
                    ctx.strokeRect(x, y, width, height)
                }
            },
            decodeTrigger(decodedString) {
                this.errorMessage = null;

                axios.post('/api/acceptAgent', {
                    code: decodedString,
                    event: this.selectedEvent
                }).then(response => {
                    this.scannerResults.push('Распознан агент ' + response.data.data.name);
                }).catch(error => {
                    this.errorMessage = 'Агента с таким кодом не найдено.';
                });
            }
        }
    });
</script>
</body>
</html>