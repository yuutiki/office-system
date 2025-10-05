// resources/js/pages/ 配下のJSファイルでBladeに読み込むJSをまとめている
// resources/js/components/kanaInput.js

export function autoKana(sourceSelector, targetSelector, options = { katakana: true }) {
    const elName = document.querySelector(sourceSelector);
    const elKana = document.querySelector(targetSelector);

    if (!elName || !elKana) return;

    let active = true;
    let timer = null;
    let flagConvert = true;
    let input = '';
    let values = [];
    let ignoreString = '';
    let baseKana = '';

    const kanaExtractionPattern = /[^ 　ぁあ-んー]/g;
    const kanaCompactingPattern = /[ぁぃぅぇぉっゃゅょ]/g;

    const isHiragana = (chara) => {
        const code = chara.charCodeAt(0);
        return (code >= 12353 && code <= 12435) || code === 12445 || code === 12446;
    };

    const toKatakana = (src) => {
        if (!options.katakana) return src;
        let str = '';
        for (let i = 0; i < src.length; i++) {
            const c = src.charCodeAt(i);
            str += isHiragana(src[i]) ? String.fromCharCode(c + 96) : src[i];
        }
        return str;
    };

    const stateClear = () => {
        baseKana = '';
        flagConvert = false;
        ignoreString = '';
        input = '';
        values = [];
    };

    const stateInput = () => {
        baseKana = elKana.value;
        flagConvert = false;
        ignoreString = elName.value;
    };

    const stateConvert = () => {
        baseKana += values.join('');
        flagConvert = true;
        values = [];
    };

    const removeString = (newInput) => {
        if (newInput.indexOf(ignoreString) !== -1) {
            return newInput.replace(ignoreString, '');
        } else {
            const ignoreArray = ignoreString.split('');
            const inputArray = newInput.split('');
            for (let i = 0; i < ignoreArray.length; i++) {
                if (ignoreArray[i] === inputArray[i]) inputArray[i] = '';
            }
            return inputArray.join('');
        }
    };

    const checkConvert = (newValues) => {
        if (!flagConvert) {
            if (Math.abs(values.length - newValues.length) > 1) {
                const tmpValues = newValues.join('').replace(kanaCompactingPattern, '').split('');
                if (Math.abs(values.length - tmpValues.length) > 1) {
                    stateConvert();
                }
            } else {
                if (values.length === input.length && values.join('') !== input) {
                    if (input.match(kanaExtractionPattern)) stateConvert();
                }
            }
        }
    };

    const setKana = (newValues) => {
        if (!flagConvert) {
            if (newValues) values = newValues;
            if (active) {
                const _val = toKatakana(baseKana + values.join(''));
                elKana.value = _val;
                elKana.dispatchEvent(new Event('change')); // jQuery .change() 相当
            }
        }
    };

    const checkValue = () => {
        let newInput = elName.value;

        if (newInput === '' && elKana.value !== '') {
            stateClear();
            setKana();
        } else {
            newInput = removeString(newInput);
            if (input === newInput) return;
            input = newInput;

            if (!flagConvert) {
                const newValues = newInput.replace(kanaExtractionPattern, '').split('');
                checkConvert(newValues);
                setKana(newValues);
            }
        }
    };

    const clearIntervalFunc = () => clearInterval(timer);

    const setIntervalFunc = () => { timer = setInterval(checkValue, 30); };

    // イベントバインド
    elName.addEventListener('focus', () => { stateInput(); setIntervalFunc(); });
    elName.addEventListener('blur', clearIntervalFunc);
    elName.addEventListener('keydown', () => { if (flagConvert) stateInput(); });

    // 初期化
    stateClear();
    active = true;
}

export function setupKanaInput(sourceSelector, targetSelector) {
    // オプションも必要であれば追加可能
    autoKana(sourceSelector, targetSelector, { katakana: true });
}





// 最後の一個がどこで読み込んでるか別途確認
// $(function() {
//     $.fn.autoKana('input[name^="name_"]', 'input[name^="kana_name_"]', {katakana: true});
// });