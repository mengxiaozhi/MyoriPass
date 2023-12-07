// 获取国籍选择框和证件输入框
var countriesSelect = document.querySelector('select[name="countries"]');
var idInput = document.querySelector('div[name="id"]');

// 监听国籍选择框的变化
countriesSelect.addEventListener('change', function() {
    // 获取选中的国籍值
    var selectedCountry = countriesSelect.value;

    // 如果选择的国籍是苗栗
    if (selectedCountry === "MAL") {
        // 显示证件输入框
        idInput.style.display = "block";
        // 设置证件输入框为必填
        idInput.querySelector('input[name="idNumber"]').required = true;
    } else {
        // 隐藏证件输入框
        idInput.style.display = "none";
        // 移除必填属性
        idInput.querySelector('input[name="idNumber"]').required = false;
    }
});