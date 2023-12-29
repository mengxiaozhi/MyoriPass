<template>
    <div class="page-scan">

        <!-- 扫码区域 -->
        <div class="QrCode">
            <video ref="video" height="100%" width="100%" id="video" autoplay></video>
        </div>
        <!-- 扫码样式一 -->
        <div class="Qr_scanner">
            <div class="box">
                <div class="line_row">
                    <div class="line"></div>
                </div>
                <div class="angle"></div>
            </div>
        </div>
    </div>
    <div class="info_notify animate__animated animate__zoomIn" v-if="authorize === '授權成功'">
        <img src="/icn_pass.png" alt="Pass">
        <h1>授權成功</h1>
        <h2></h2>
        <h2>
            被授權人：{{ displayedName }} <br>
            要授權人：{{ authorize_user }}
        </h2>
        <p>授權編號：{{ recordCode }}</p>
        <p>授權時間：{{ time }}</p>
        <div class="button">
            <RouterLink to="/main/user">
                <button class="btn btn-default" id="login"><h3>完成</h3></button>
            </RouterLink>
        </div>
    </div>
    <div class="animate__animated animate__zoomIn info_notify"
        v-else-if="authorize === 'QR数据不匹配' || authorize === '不能授权给自己' || authorize === '未找到用户' || authorize === '非法请求'">
        <img src="/icn_nopass.png" alt="NoPass">
        <h1>授權失敗</h1>
        <h5>原因：{{ authorize }}</h5>
        <div class="button">
            <RouterLink to="/main/user">
                <button class="btn btn-default" id="login"><h3>完成</h3></button>
            </RouterLink>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
// WebRTC适配器 只需要引入就ok
import 'webrtc-adapter'
import { BrowserMultiFormatReader } from '@zxing/library'
import { ref } from 'vue'
export default {
    name: 'scanCodePage',
    setup() {
        const authorize = ref('');
        const authorize_user = ref('');
        const time = ref('');
        const displayedName = ref('');
        const recordCode = ref('');

        return {
            authorize,
            authorize_user,
            time,
            displayedName,
            recordCode,
        };
    },
    data() {
        return {
            codeReader: null,
        };
    },
    mounted() {
        this.codeReader = new BrowserMultiFormatReader()
        this.openScan()

    },
    beforeUnmount() {
        this.codeReader && this.codeReader.reset()
    },
    methods: {
        async openScan() {
            this.codeReader
                .listVideoInputDevices()
                .then((videoInputDevices) => {
                    // 默认获取第一个摄像头设备id
                    let firstDeviceId = videoInputDevices[0].deviceId
                    // 获取第一个摄像头设备的名称
                    const videoInputDeviceslablestr = JSON.stringify(
                        videoInputDevices[0].label
                    )
                    if (videoInputDevices.length > 1) {
                        // 判断是否后置摄像头
                        if (videoInputDeviceslablestr.indexOf('back') > -1) {
                            firstDeviceId = videoInputDevices[0].deviceId
                        } else {
                            firstDeviceId = videoInputDevices[1].deviceId
                        }
                    }
                    this.codeReader && this.codeReader.reset() // 重置
                    this.decodeFromInputVideoFunc(firstDeviceId)
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        decodeFromInputVideoFunc(firstDeviceId) {
            this.codeReader.decodeFromInputVideoDeviceContinuously(
                firstDeviceId,
                'video',
                (result, err) => {
                    if (result) {
                        const scannedText = result.text; //result為全部json objact
                        console.log('扫描结果', scannedText)
                         // 停止掃描
                        this.scanning = false;
                        this.codeReader && this.codeReader.reset();

                        // console.log('扫描结果', result)
                        // if (result.text) {
                        //     this.clickIndexLeft(result.text)
                        // }

                        // 使用 Axios 發送 POST 請求
                        const formData = new FormData();
                        formData.append('qrdata', scannedText);

                        axios.post('/api/reader.php', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                console.log('後端返回的資料', response.data);
                                this.authorize = response.data.message;
                                console.log('authorize:', this.authorize);
                                this.time = response.data.time;
                                this.displayedName = response.data.displayedName;
                                this.recordCode = response.data.recordCode;
                                this.authorize_user = response.data.authorize_user;
                            })

                            .catch(error => {
                                console.error('POST 請求失敗', error);
                                console.log(this.authorize);
                            });

                    }
                    if (err && !err) {
                        console.error(err)
                    }
                }
            )
        },
        // 停止扫描，并返回上一页
        clickIndexLeft(result) {
            this.codeReader && this.codeReader.reset()
            this.codeReader = null
            // this.$route.params.result = result
            // this.$router.back()
        }
    }
}
</script>

<style scoped>
img{
    padding-bottom: 10px;
}
p{
    margin-block-start: 0;
    margin-block-end: 0;
}
.page-scan {
    margin: -50px;
}

.QrCode {
    /* width: 100vw; */
    height: 100vh;
    position: relative;
    z-index: 1;

    #video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

.Qr_scanner {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.Qr_scanner .box {
    width: 75vw;
    height: 75vw;
    max-height: 75vh;
    max-width: 75vh;
    position: relative;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border: 1px solid #c4c4c4;

    .line_row {
        width: 100%;
        overflow: hidden;
        background-image: linear-gradient(0deg,
                transparent 24%,
                rgba(136, 176, 255, 0.1) 25%,
                rgba(136, 176, 255, 0.1) 26%,
                transparent 27%,
                transparent 74%,
                rgba(136, 176, 255, 0.1) 75%,
                rgba(136, 176, 255, 0.1) 76%,
                transparent 77%,
                transparent),
            linear-gradient(90deg,
                transparent 24%,
                rgba(136, 176, 255, 0.1) 25%,
                rgba(136, 176, 255, 0.1) 26%,
                transparent 27%,
                transparent 74%,
                rgba(136, 176, 255, 0.1) 75%,
                rgba(136, 176, 255, 0.1) 76%,
                transparent 77%,
                transparent);
        background-size: 3rem 3rem;
        background-position: -1rem -1rem;
        animation: Heightchange 2s infinite;
        animation-timing-function: cubic-bezier(0.53, 0, 0.43, 0.99);
        animation-delay: 1.4s;
        border-bottom: 1px solid rgba(136, 176, 255, 0.1);
        display: flex;
        justify-content: center;
        align-items: flex-end;
    }
}

.Qr_scanner .line {
    width: 100%;
    height: 3px;
    background: #c4c4c4;
    opacity: 0.58;
    filter: blur(4px);
}

.Qr_scanner .box:after,
.Qr_scanner .box:before,
.Qr_scanner .angle:after,
.Qr_scanner .angle:before {
    content: '';
    display: block;
    position: absolute;
    width: 78px;
    height: 78px;
    border: 0.3rem solid transparent;
}

.Qr_scanner .box:after,
.Qr_scanner .box:before {
    top: -7px;
    border-top-color: #c4c4c4;
}

.Qr_scanner .angle:after,
.Qr_scanner .angle:before {
    bottom: -7px;
    border-bottom-color: #c4c4c4;
}

.Qr_scanner .box:before,
.Qr_scanner .angle:before {
    left: -7px;
    border-left-color: #c4c4c4;
}

.Qr_scanner .box:after,
.Qr_scanner .angle:after {
    right: -7px;
    border-right-color: #c4c4c4;
}

@keyframes radar-beam {
    0% {
        transform: translateY(-100%);
    }

    100% {
        transform: translateY(0);
    }
}

@keyframes Heightchange {
    0% {
        height: 0;
    }

    100% {
        height: 100%;
    }
}

.info_notify {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction:column;

    background-color: #ffffff;
    width: 100%;
    height: 100%;
    z-index: 998;
}
</style> 