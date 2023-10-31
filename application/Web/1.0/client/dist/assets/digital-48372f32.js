import{_ as w,r as a,u as x,c as h,d as f,g as i,m as k,e,j as S,k as c,v as m,n as V,F as L,a as T,q,s as A}from"./index-4ef9b014.js";const C={setup(){const n=a(""),s=a(""),v=a(""),t=a("MAL"),p=a(""),_=a(""),o=a(!1),r=a(""),g=a([]),b=x();return{email:n,name:s,selectedCountry:t,id:v,password:p,confirmPassword:_,registrationSuccess:o,message:r,countries:g,submitForm:async y=>{if(y.preventDefault(),p.value!==_.value){r.value="密碼與確認密碼不符，請重新輸入。";return}const d=new URLSearchParams;d.append("email",n.value),d.append("name",s.value),d.append("countries",t.value),d.append("password",p.value);try{const u=await T.post("/api/digital.php",d);u.data.success===!0?(o.value=!0,r.value=u.data,window.scrollTo({top:0,behavior:"smooth"})):r.value=u.data}catch(u){r.value="提交時發生錯誤: "+u.toString()}},letToLogin:()=>{b.push("/user/login")}}}},l=n=>(q("data-v-1e461071"),n=n(),A(),n),F=l(()=>e("i",{class:"fas fa-check-circle"},null,-1)),M=l(()=>e("span",{class:"bold-text"},"點我登入",-1)),U=l(()=>e("h2",null,"注冊成爲苗栗國數位公民",-1)),E=l(()=>e("h3",{class:"title-section"},"關於使用",-1)),P=l(()=>e("p",{style:{display:"flex","justify-content":"center"}},[i(" 提交申請即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。"),e("br"),i(" *此表單為數字公民身份申請表，並不具備完整的公民權利，我們也不會將您的資料納入我們的國民系統不會给予您My Number編號。如果您後續想成爲苗栗國公民，請準備您的身份證明文件進行KYC以及填寫入籍申請表，審核完成後入籍即成爲苗栗國公民。"),e("br"),i(" *注意，數位公民身份和外國人身份可以同時存在，如果您已經具備了外國人賬號請使用其他Email進行注冊或直接使用原賬號進行身份轉換，Email為數位公民身份的唯一憑證。 ")],-1)),z={class:"register-form"},D=l(()=>e("h3",{class:"title-section"},"輸入帳號資料",-1)),I=l(()=>e("label",null,[e("h3",null,"Email")],-1)),N=l(()=>e("label",null,[e("h3",null,"姓名")],-1)),Z=l(()=>e("label",{for:"options"},[e("h3",null,"國籍")],-1)),B=l(()=>e("option",{value:"MAL"},"苗栗（數位）",-1)),R=[B],j=l(()=>e("label",null,[e("h3",null,"密碼")],-1)),G=l(()=>e("p",null,[i(" ・ 10個字元以上"),e("br"),i(" ・ 大寫英文+小寫英文+數字+符號的組合"),e("br"),i(" ・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_ ")],-1)),K=l(()=>e("label",null,[e("h3",null,"確認密碼")],-1)),Y=l(()=>e("div",null,[e("button",{type:"submit",class:"btn btn-default",id:"login"},[e("h3",null,"註冊數位公民")])],-1));function H(n,s,v,t,p,_){return h(),f(L,null,[t.registrationSuccess?(h(),f("div",{key:0,onClick:s[0]||(s[0]=(...o)=>t.letToLogin&&t.letToLogin(...o)),class:"success-message"},[F,i(" 註冊成功！"),M])):k("",!0),U,E,P,e("div",z,[D,e("form",{onSubmit:s[6]||(s[6]=S((...o)=>t.submitForm&&t.submitForm(...o),["prevent"]))},[e("div",null,[I,c(e("input",{type:"email","onUpdate:modelValue":s[1]||(s[1]=o=>t.email=o),name:"email",placeholder:"Email",maxlength:"128",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",required:""},null,512),[[m,t.email]])]),e("div",null,[N,c(e("input",{type:"text","onUpdate:modelValue":s[2]||(s[2]=o=>t.name=o),name:"name",placeholder:"姓名",pattern:".{2,}$",maxlength:"32",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",required:""},null,512),[[m,t.name]])]),e("div",null,[Z,c(e("select",{name:"countries","onUpdate:modelValue":s[3]||(s[3]=o=>t.selectedCountry=o),required:""},R,512),[[V,t.selectedCountry]])]),e("div",null,[j,G,c(e("input",{type:"password","onUpdate:modelValue":s[4]||(s[4]=o=>t.password=o),name:"password",placeholder:"密碼",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",pattern:"^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\\d]).{10,}$",required:""},null,512),[[m,t.password]])]),e("div",null,[K,c(e("input",{type:"password","onUpdate:modelValue":s[5]||(s[5]=o=>t.confirmPassword=o),name:"confirm_password",placeholder:"確認密碼",onkeyup:"this.value=this.value.replace(/\\s+/g,'')",pattern:"^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\\d]).{10,}$",required:""},null,512),[[m,t.confirmPassword]])]),Y],32)])],64)}const W=w(C,[["render",H],["__scopeId","data-v-1e461071"]]);export{W as default};
