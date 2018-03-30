export default {
    methods: {
        decodeValues: function (values){
            return values;

            for (var fieldName in values) {
                if (typeof(values[fieldName]) === 'object'){
                    values[fieldName] = this.decodeValues(values[fieldName]);
                    continue;
                }
                var decodedString = decodeURIComponent(values[fieldName]);
                values[fieldName] = decodedString.replace(/\+/g, ' ');
            }

            return values;
        }
    }
}