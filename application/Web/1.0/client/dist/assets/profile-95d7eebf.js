import{r as o,i as V,u as D,o as E,a as m,c as u,d,e,k as s,v as c,n as N,F as b,p as q,j as y,y as L,h as B,t as F}from"./index-4ef9b014.js";import{_ as P}from"./icn_update-851772f2.js";const R="/icn_download.svg",w="/icn_attention.svg",$=e("h2",null,"管理MyoriPas賬號資料",-1),j=e("h3",{class:"title-section"},"更新帳號基本資料",-1),A=["onSubmit"],C=e("label",null,[e("h3",null,"Email")],-1),W=e("label",null,[e("h3",null,"姓名")],-1),z=e("label",{for:"options"},[e("h3",null,"國籍")],-1),T=e("option",{value:""},"請選擇國家",-1),G=["value"],H={name:"id"},I=e("label",null,[e("h3",null,"MyNumber編號/護照號碼")],-1),J={key:0},K=e("p",null,"・ 國籍為苗栗國或東亞聯邦成員國，根據「苗栗國個人資料管理條例」無法修改證件資料",-1),O=e("div",null,[e("button",{type:"submit",class:"btn btn-default icn_button",id:"login"},[e("img",{src:P,alt:"warning"}),e("h3",null,"更新帳號資料")])],-1),Q=B('<h3 class="title-section">個人資料管理</h3><div class="register"><a href="/api/download_data.php"><button class="btn btn-default icn_button"><img src="'+R+'" alt="dowload"><h3>下載賬號個資</h3></button></a></div>',2),X=e("img",{src:w,alt:"warning"},null,-1),Y=e("h3",null,"刪除全部資料",-1),Z=[X,Y],ee={id:"hidden-window"},te=e("h2",null,"刪除全部資料",-1),ae=e("h3",{class:"title-section"},"驗證密碼",-1),le=["onSubmit"],ne=e("label",null,[e("h3",null,"密碼")],-1),oe=e("div",{class:"warning"},[e("button",{type:"submit",class:"btn btn-default icn_button",id:"delete"},[e("img",{src:w,alt:"warning"}),e("h3",null,"確認刪除資料")])],-1),ue={__name:"profile",setup(se){const r=o(""),p=o(""),n=o(""),i=o(""),h=o([]),v=o(!1),_=o(""),g=V(),f=D(),S=async()=>{try{const t=await m.get("/api/profile_get.php");t.data.success?(r.value=t.data.email,p.value=t.data.name,n.value=t.data.countries,i.value=t.data.id):console.error("無法取得profile")}catch(t){console.error("Error loading profile:",t)}},x=async()=>{const t=new URLSearchParams;t.append("email",r.value),t.append("name",p.value),t.append("countries",n.value),t.append("id",i.value);try{const a=await m.post("/api/profile_change.php",t);alert(a.data.message)}catch(a){console.error("提交錯誤",a)}},k=()=>{v.value=!v.value},U=async()=>{try{const t=new URLSearchParams;t.append("username",r.value),t.append("password",_.value);const a=await m.post("/api/delete.php",t);a.data.success==!0?(alert(a.data.message),g.clearUser(),g.setStatus(0),f.push("/")):alert(a.data.message)}catch(t){console.error("帳號刪除發生錯誤",t)}};return E(async()=>{await S();try{const t=await m.get("https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json");h.value=t.data,!n.value&&h.value.length>0&&(n.value=h.value[0].code)}catch(t){console.error("Error loading countries:",t)}}),(t,a)=>(u(),d(b,null,[$,j,e("form",{onSubmit:y(x,["prevent"])},[e("div",null,[C,s(e("input",{type:"email","onUpdate:modelValue":a[0]||(a[0]=l=>r.value=l),name:"email",placeholder:"Email",maxlength:"128",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",required:""},null,512),[[c,r.value]])]),e("div",null,[W,s(e("input",{type:"text","onUpdate:modelValue":a[1]||(a[1]=l=>p.value=l),name:"name",placeholder:"姓名",pattern:".{2,}$",maxlength:"32",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",required:""},null,512),[[c,p.value]])]),e("div",null,[z,s(e("select",{"onUpdate:modelValue":a[2]||(a[2]=l=>n.value=l),name:"countries",required:""},[T,(u(!0),d(b,null,q(h.value,(l,M)=>(u(),d("option",{key:M,value:l.code},F(l.name),9,G))),128))],512),[[N,n.value]])]),e("div",H,[I,n.value==="MAL"?(u(),d("div",J,[K,s(e("input",{type:"text","onUpdate:modelValue":a[3]||(a[3]=l=>i.value=l),name:"id",placeholder:"MyNumber編號/護照號碼",pattern:".{5,}$",maxlength:"9",disabled:"disabled",onkeyup:"this.value=this.value.replace(/\\s+/g,\\'\\')"},null,512),[[c,i.value]])])):s((u(),d("input",{key:1,type:"text","onUpdate:modelValue":a[4]||(a[4]=l=>i.value=l),name:"id",placeholder:"MyNumber編號/護照號碼",pattern:".{5,}$",maxlength:"9",onkeyup:"this.value=this.value.replace(/\\s+/g,\\'\\')"},null,512)),[[c,i.value]])]),O],40,A),Q,e("div",{class:"warning"},[e("button",{class:"btn btn-default icn_button",onClick:k},Z)]),s(e("div",ee,[te,ae,e("div",null,[e("form",{onSubmit:y(U,["prevent"])},[e("div",null,[ne,s(e("input",{type:"password","onUpdate:modelValue":a[5]||(a[5]=l=>_.value=l),placeholder:"密碼",required:""},null,512),[[c,_.value]])]),oe],40,le)])],512),[[L,v.value]])],64))}};export{ue as default};
