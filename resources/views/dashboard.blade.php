<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Custom SMS preview dashboard</title>
</head>
<body>
    <div x-data="sms">
        <div class="flex flex-col bg-gray-900 h-screen overflow-hidden p-10">
            <!-- HEAD -->
            <div class="w-full p-4 bg-gray-800 rounded-sm">
                <b class="text-white"> Inbox</b>
            </div>
            <!-- HEAD -->

            <!-- BODY -->
            <div class="flex h-full rounded-sm">
                <div class="flex flex-col space-y-8 bg-gray-800 w-4/12 p-4">
                    <!-- OPTIONS GBLOBAL -->
                    <div class="flex justify-between w-full">
                        <div class="flex items-center space-x-4">
                            <span class="text-lg font-bold text-white" x-text="'SMS (' + messages.length + ')'"></span>
                            <svg class="h-4 w-4 hover:opacity-60 transition cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="#2563eb" d="M256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C201.7 512 151.2 495 109.7 466.1C95.2 455.1 91.64 436 101.8 421.5C111.9 407 131.8 403.5 146.3 413.6C177.4 435.3 215.2 448 256 448C362 448 448 362 448 256C448 149.1 362 64 256 64C202.1 64 155 85.46 120.2 120.2L151 151C166.1 166.1 155.4 192 134.1 192H24C10.75 192 0 181.3 0 168V57.94C0 36.56 25.85 25.85 40.97 40.97L74.98 74.98C121.3 28.69 185.3 0 255.1 0L256 0zM256 128C269.3 128 280 138.7 280 152V246.1L344.1 311C354.3 320.4 354.3 335.6 344.1 344.1C335.6 354.3 320.4 354.3 311 344.1L239 272.1C234.5 268.5 232 262.4 232 256V152C232 138.7 242.7 128 256 128V128z"/>
                            </svg>
                        </div>
                        <div class="flex space-x-2 items-center cursor-pointer hover:opacity-60 transition">
                            <span style="color:#f85069" class="font-bold">Clear</span>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="#f85069" d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM207 199L127 279C117.7 288.4 117.7 303.6 127 312.1C136.4 322.3 151.6 322.3 160.1 312.1L199.1 273.9V408C199.1 421.3 210.7 432 223.1 432C237.3 432 248 421.3 248 408V273.9L287 312.1C296.4 322.3 311.6 322.3 320.1 312.1C330.3 303.6 330.3 288.4 320.1 279L240.1 199C236.5 194.5 230.4 191.1 223.1 191.1C217.6 191.1 211.5 194.5 207 199V199z"/>
                            </svg>
                        </div>
                    </div>
                    <!-- OPTIONS GBLOBAL -->

                    <!-- LIST CONTACT -->
                    <div class="flex flex-col divide-y divide-gray-600 overflow-y-auto h-5/6">

                        <template x-for="message in messages" :key="message.id">
                            <div class="flex w-full p-4 space-x-4 cursor-pointer hover:opacity-80 transition">
                                <div class="flex w-full space-x-2">
                                    <div class="flex space-x-2 items-center">
                                        <div class="h-4 w-4 rounded-full bg-blue-600">
                                        </div>
                                        <div style="background:#97989e" class="flex items-center justify-center h-12 w-12 rounded-full text-white font-bold">
                                            <span class="font-bold">B</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-1">
                                        <span class="text-lg font-bold text-white" x-text="message.number"></span>
                                        <p class="truncate w-60 text-gray-400" x-text="message.lastMessage.message">
                                        </p>
                                    </div>
                                </div>
                                <i class="text-sm text-gray-500">hier</i>
                                <div class="flex items-end">
                                    <svg class="h-3 w-3 cursor-pointer hover:opacity-60 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="#f85069" d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM207 199L127 279C117.7 288.4 117.7 303.6 127 312.1C136.4 322.3 151.6 322.3 160.1 312.1L199.1 273.9V408C199.1 421.3 210.7 432 223.1 432C237.3 432 248 421.3 248 408V273.9L287 312.1C296.4 322.3 311.6 322.3 320.1 312.1C330.3 303.6 330.3 288.4 320.1 279L240.1 199C236.5 194.5 230.4 191.1 223.1 191.1C217.6 191.1 211.5 194.5 207 199V199z"/>
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- LIST CONTACT -->
                </div>

                <!-- CANVAS -->
                <div class="flex flex-col space-y-4 bg-gray-700 w-8/12">
                    <!-- BUTTON SWITCH -->
                    <div class="flex justify-end">
                        <div class="flex justify-end w-4/12 p-2 divide-x">
                            <button x-on:click="platform = 'ios'"
                                    x-bind:class="platform == 'ios' ? 'bg-gray-900' : 'opacity-25'"
                                    class="flex space-x-2 items-center bg-gray-800  hover:opacity-80 transition p-2 rounded-tl-lg rounded-bl-lg text-white">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="#fff" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/>
                                </svg>
                                <span>Iphone</span>
                            </button>
                            <button  x-on:click="platform = 'android'"
                                     x-bind:class="platform == 'android' ? 'bg-gray-900' : 'opacity-25'"
                                     class="flex space-x-2 items-center bg-gray-800  hover:opacity-80 transition p-2 rounded-tr-lg rounded-br-lg text-white">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="#fff" d="M420.55,301.93a24,24,0,1,1,24-24,24,24,0,0,1-24,24m-265.1,0a24,24,0,1,1,24-24,24,24,0,0,1-24,24m273.7-144.48,47.94-83a10,10,0,1,0-17.27-10h0l-48.54,84.07a301.25,301.25,0,0,0-246.56,0L116.18,64.45a10,10,0,1,0-17.27,10h0l47.94,83C64.53,202.22,8.24,285.55,0,384H576c-8.24-98.45-64.54-181.78-146.85-226.55"/>
                                </svg>
                                <span>Android</span>
                            </button>
                        </div>
                    </div>
                    <!-- BUTTON SWITCH -->

                    <!-- BIG MOBILE -->
                    <div class="flex justify-center h-full">
                        <div class="relative">
                            <div class="absolute w-full h-full pt-10 pb-20 px-4">
                                <div class="flex flex-col sw-full h-full p-1">
                                    <div style="background:#f3f3f3" class="flex justify-between mt-1 border-b border-gray-300 p-2 rounded-tl-3xl rounded-tr-3xl">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                            <path fill="#2563eb" d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/>
                                        </svg>
                                        <div class="flex flex-col space-y-1 items-center">
                                            <div style="background:#97989e" class="flex items-center justify-center h-10 w-10 rounded-full text-white font-bold">
                                                <span class="font-bold">B</span>
                                            </div>
                                            <span class="font-bold text-gray-900 text-xs">{{ config('app.name') }}</span>
                                        </div>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path fill="#2563eb" d="M384 112v288c0 26.51-21.49 48-48 48h-288c-26.51 0-48-21.49-48-48v-288c0-26.51 21.49-48 48-48h288C362.5 64 384 85.49 384 112zM576 127.5v256.9c0 25.5-29.17 40.39-50.39 25.79L416 334.7V177.3l109.6-75.56C546.9 87.13 576 102.1 576 127.5z"/>
                                        </svg>
                                    </div>
                                    <div class="bg-white h-5/6 overflow-y-auto">
                                        <template x-for="m in currentMessage.messages" :key="m.id">
                                            <div class="flex flex-col space-y-2 p-2">
                                                <div class="flex justify-center">
                                                    <span class="text-xss text-gray-800">mer, 8 juin à 14:32</span>
                                                </div>
                                                <div style="background:#f3f3f3" class="w-5/6 p-4 rounded-lg text-gray-900">
                                                    bonjour
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex h-1/6 items-end bg-white px-4 pb-1">
                                        <div class="flex items-center w-full space-x-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5" id="Calque_1" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 23">
                                                    <path d="M22.26,2.57H18.83l-.14-1.15A1.25,1.25,0,0,0,17.44.31h-9A1.26,1.26,0,0,0,7.24,1.42L7.11,2.57H3.75A3.73,3.73,0,0,0,0,6.31V19.12a3.74,3.74,0,0,0,3.74,3.75H22.26A3.75,3.75,0,0,0,26,19.12V6.31A3.74,3.74,0,0,0,22.26,2.57Z" fill="#7b7b7c"/><path d="M13,6.28a5.83,5.83,0,1,0,5.82,5.82A5.83,5.83,0,0,0,13,6.28Zm0,10.94a5.12,5.12,0,1,1,5.12-5.12A5.11,5.11,0,0,1,13,17.22Z" fill="#d6d6d6"/><circle cx="19.86" cy="7.62" r="1.04" fill="#d6d6d6"/>
                                                </svg>
                                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 23">
                                                    <g style="isolation:isolate">
                                                        <g id="Calque_1" data-name="Calque 1">
                                                            <rect x="0.84" y="0.28" width="34.76" height="21.5" rx="10.75" fill="#7b7b7c"/>
                                                            <path d="M39.23,11A10.75,10.75,0,0,1,28.48,21.79H27.37a10.76,10.76,0,0,0,0-21.51h1.11A10.76,10.76,0,0,1,39.23,11Z" fill="#7b7b7c"/>
                                                            <rect x="17.49" y="6.48" width="1.46" height="14.41" rx="0.73" transform="translate(31.9 -4.53) rotate(90)" fill="#f3f3f3"/>
                                                            <image width="39" height="43" transform="translate(3 -11)" opacity="0.15" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAArCAYAAAD7YZFOAAAACXBIWXMAAAsSAAALEgHS3X78AAACVklEQVRYR+2X25LjIBBDRZL//+OYeZhVVsh9IZet2YdRFQU2BB+rG4LHnBP/qy7dgJ/UL9yrunUDIo0xRtU/P5TIY3eeDijTO6BbcAa2C/mY+FXAFk7AvPY2IEDSfhmyhEvAKlgHmn7vGcAUzsAcyu+pZlLYtw0YwiVgWi7SdhHmCNrs3wLc3Uoc6oIYUJ0a+IY6/owl5AAwxxijAzzBbbh2xRmOv1GntO+Qe61j1I5z6hrL1a4phbsjDvvBsZ17HZy76ICEVOfUpbvMxVB7GqSq4EZQK9hN2vpAdS1yblkYlXsZnE+q+aPu3aTNfDrkGlgXCfvoLPtDdWEFVjCH0/BSDCulcFy1nKt0bwdOlYWYbQIw1+hW5lrpXgbHt4vkTioosObUFetepy/xcC6TbgOZGBJt670s5L7dMA+9fE8SHMkqOH+rCCwaB8SwDuT1SZ1zDqSF4dK8UtAI4inAE1yy50RQLHesoJoC1CmMO6pWa5RnCuTh0t8AK2zmaqmdrUTBBs6AFZw6iqAuFcLNOaetHncv+nuK/hk05FFeluqc04nUvYH11DGRHwKinNwCTOHEPc+9w4dK0cT3HI0AS8jOOZWDedg9rMBfmMq9FLKEC9wDVkhO7Jutj/XyGecCQDqkLmrIo4V0SB2t3nB/beECaQj5IG4x0UbrgFFYQ7Vf/FTxge3F5bl1AsxOwttwAPzkoDDeVjnc0n7nA2eRbc4+Ka8797Qu9ZRzqsDFpVva+oBHu/ugBt6Ao6JDYqcdMOADcNQO5C4U9TG4f6HuJPyj+oV7VV/4kIwrre1d/gAAAABJRU5ErkJggg==" style="mix-blend-mode:multiply"/>
                                                            <rect x="19.98" y="3.42" width="1.46" height="14.41" rx="0.73" transform="matrix(0.87, -0.5, 0.5, 0.87, -2.54, 11.78)" fill="#f3f3f3"/>
                                                            <image width="39" height="43" transform="translate(-2 -11)" opacity="0.15" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAArCAYAAAD7YZFOAAAACXBIWXMAAAsSAAALEgHS3X78AAACRElEQVRYR+2XUXOEIAyEF6///xdX04drvGVNINhO24fuTCbKgXyXBMFmZvir2mYdflP/cHf1NuuwotZay36zG8XdbozpNAKKtAJ5Gy6AmkF2E1Ugb8EJWBOfiScyYA64DEdg7GeARp6vh4BLC0LAFIrvVQzVtbfWWgZYhkvAMmNZYufvGWAJbgC2Bd77aSoP8t6ufTtN4SZgaho5jlTDC+ygfgY859HoTeFECvYQz/AMttMzHLSDizSES6LGYG4KCPTp9GdweyPv7Z0qkcvS+QiM4YAnGEfN06kRDpXCJTuAT87RekMP54uC6wp4QmxB+ymtu++IHMM9aNyGV9S4zrhUhprBVWvOAT2y/OpQMAYcKoQL9k4Fy+rOU8rvOK6zofRVsmGsKqQb12UGY+JTjeCilFZMZWJAAQyY1xwrg3XxhJ5OrrvMdOypKlwTr9KJDrJd7rmv9w91gSseu30Cn1DH7GQMqKv4BLt9KvlUlhY9ZXjbCHCaUqAOxw9y2/GKmEI6zDt6wKgOU13gzMyS1Eap3D/bdMPnyDlgVnPpUb0SuSiNegQ68BL/AU1ttHpTjeB8YEMP5m3eR08iDKer1dADfvkDx8hrhLwtglPIS0pnn4YhnNSdiefCN1xfI1oC0QIYQrlmkePJD1zPajO4zKZRAzD+qA6O6Xyd7aVAAoQFMGACB1wA3a9uZ+ckVTCgAAeEgHod6VJfK2BAEQ4I99wq3DKUqwznKh4MANyHci3DuUaQX4Vy3Yb7Cc2+IX5V/3B39QGDXn49kSYn1gAAAABJRU5ErkJggg==" style="mix-blend-mode:multiply"/>
                                                            <rect x="8.72" y="9.75" width="14.41" height="1.46" rx="0.73" transform="translate(-1.11 19.03) rotate(-60)" fill="#f3f3f3"/></g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="flex justify-between border px-2 py-1 rounded-full w-full opacity-60">
                                                <span class="text-sm font-bold text-gray-600">Message</span>
                                                <div style="background:#34c659" class="flex items-center justify-center h-6 w-6  p-1 rounded-full text-white font-bold">
                                                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                        <path fill="#ffffff" d="M310.6 182.6c-12.51 12.51-32.76 12.49-45.25 0L192 109.3V480c0 17.69-14.31 32-32 32s-32-14.31-32-32V109.3L54.63 182.6c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l128-128c12.5-12.5 32.75-12.5 45.25 0l128 128C323.1 149.9 323.1 170.1 310.6 182.6z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="h-160 xl:h-176"
                                 x-show="platform == 'ios'"
                                 style="height: 40rem;"
                                 src="/sms-custom/big-iphone.svg" alt="Iphone">
                            <img class="h-160 xl:h-176"
                                 x-show="platform == 'android'"
                                 style="height: 40rem;"
                                 src="/sms-custom/big-android.svg" alt="Android">
                        </div>
                    </div>
                    <!--BIG MOBILE -->

                    <!-- SMALL MOBILE -->
                    <div class="flex justify-end p-2">
                        <div class="w-10 bg-gray-600 p-1 rounded-lg">
                            <img src="/sms-custom/small-iphone.png" alt="">
                        </div>
                    </div>
                    <!-- SMALL MOBILE -->
                </div>
                <!-- CANVAS -->
            </div>
            <!-- BODY -->
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sms', () => ({
                platform: 'ios',
                messages: @json($messages),
                currentMessage: null,

                init() {
                    this.currentMessage = this.messages[0]
                }
            }))
        })
    </script>
</body>
</html>
