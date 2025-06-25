let en = [];
let ar = [];
if (window.core.enJson != '') {
    en = window.core.enJson;
}
if (window.core.arJson != '') {
    ar = window.core.arJson;
}
let Translation = {
    ___: function (str) {
        let lang = window.core.lang;
        let langStr = lang === 'en' ? en : ar;
        if (lang === 'ar') {
            if (langStr[str] !== undefined && langStr[str] != null && langStr[str] !== "") {
                return langStr[str];
            } else {
                return str;
            }
        } else {
            return str;
        }
    }
};
export default Translation;
