export default {
    install: (Vue) => {

        function __(str, params = {}) {
            try {
                var text = str.split('.').reduce(function (o, i) {
                    return (o === undefined || o[i] === undefined) ? undefined : o[i];
                }, window.i18n)

                for (var key in params) {
                    text = text.replace(':' + key, params[key]);
                }
            } catch (err) {
                return str;
            }

            return text !== undefined ? text : str;
        }

        Vue.mixin({
			methods: {
				__,
			},
		});
    }
}
