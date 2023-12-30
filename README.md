# 苗栗通MyoriPass
地址：https://pass.myori.org

## 簡介
這是一個架空國家的出入國申報系統專案，提供用戶登入/註冊、帳號管理、出入境申報、QrCode自動通關等功能（按照GDPR規則設計）。<br>
其實是一個很好的新人學習專案，或者用來變成健康碼？？？會員管理系統之類的東西。<br>
PS.很多東西可能看起來奇奇怪怪的，沒錯，不要懷疑

## 構建
##### 前端
```bash
cd pass.myori.org_vue
npm install  
npm run build #構建
```
把構建出來的Dist資料夾丟到服務器的 /main/ 下面，主程序默認路徑為/main，可以更改vite構建指令改為根目錄<br>
##### 後端
/pass.myori.org_php<br>
這個路徑下的所有東西則丟到服務器的的 /Api/ 資料夾下，所有的API接口都在這裡。
##### 介紹頁面/Blog
```bash
cd pass.myori.org_hexo
npm install  
hexo g #構建
```
把構建出來的Public資料夾丟到根目錄的下，是介紹首頁兼Blog。

## 貢獻
萌小志Mengxiaozhi<br>
Angelo0218<br>
感謝所有為這個專案做出貢獻的開發者和貢獻者。

## 授權
本專案採用MIT授權

## 聯絡方式
如有問題或建議，請通過電子郵件聯絡我們：mengxiaozhi@galigali.club

## 其他
本專案有安卓版本之代碼，採用Capacitor構建。<br>

**最後更新：** 2023年12月30日
