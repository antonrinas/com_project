<template>
    <div id="add_comment_form">
        <p>Вы можете добавить новый комментарий, используя форму ниже:</p>

        <b-form v-on:submit.prevent="save">
            <b-form-group>
                <b-form-input id="user_name"
                              v-bind:class="{'is-invalid': formErrors.user_name}"
                              type="text"
                              v-model="formData.user_name"
                              placeholder="Ваше имя*"
                              v-on:input="formErrors.user_name = ''"
                ></b-form-input>
                <div v-if="formErrors.user_name" class="error_message">
                    {{ formErrors.user_name }}
                </div>
            </b-form-group>
            <b-form-group>
                <b-form-textarea id="content"
                                 v-bind:class="{'is-invalid': formErrors.content}"
                                 v-model="formData.content"
                                 placeholder="Комментарий*"
                                 :rows="3"
                                 :max-rows="6"
                                 v-on:input="formErrors.content = ''"
                ></b-form-textarea>
                <div v-if="formErrors.content" class="error_message">
                    {{ formErrors.content }}
                </div>
            </b-form-group>

            <div class="text-center">
                <b-button type="submit" :disabled="requesting" variant="primary">Добавить</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    import bButton from 'bootstrap-vue/es/components/button/button';
    import bForm from 'bootstrap-vue/es/components/form/form';
    import bFormGroup from 'bootstrap-vue/es/components/form-group/form-group';
    import bFormInput from 'bootstrap-vue/es/components/form-input/form-input';
    import bFormTextarea from 'bootstrap-vue/es/components/form-textarea/form-textarea';

    export default {
        components: {
            'b-button': bButton,
            'b-form': bForm,
            'b-form-group': bFormGroup,
            'b-form-input': bFormInput,
            'b-form-textarea': bFormTextarea,
        },
        data(){
            return {
                formData: {
                    user_name: '',
                    content: '',
                },
                formErrors: {
                    user_name: '',
                    content: '',
                },
                requesting: false,
            }
        },
        methods: {
            save: function () {
                this.requesting = true;
                var data = new FormData();
                data.append('user_name', this.formData.user_name);
                data.append('content', this.formData.content);
                var vueInstance = this;
                axios.post('/api/comments', data).then(function (response) {
                    if (response.status === 201){
                        vueInstance.reset();
                        vueInstance.$emit('added');
                    } else {
                        vueInstance.$emit('error', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                    vueInstance.requesting = false;
                }).catch(function (error) {
                    vueInstance.requesting = false;
                    if(!error.response) {
                        console.log('Ошибка подключения к серверу');
                        return;
                    }
                    if (error.response.status === 422) {
                        for (var propertyName in vueInstance.formErrors){
                            if (error.response.data.messages.hasOwnProperty(propertyName)) {
                                vueInstance.formErrors[propertyName] = error.response.data.messages[propertyName];
                            }
                        }
                        return;
                    }
                    console.log(error.response.status);
                });
            },
            reset: function() {
                this.formData = {
                    user_name: '',
                    content: '',
                };
                this.formErrors = {
                    user_name: '',
                    content: '',
                };
            },
        },
    }
</script>

<style scoped>
    #add_comment_form {
        margin-top: 2rem;
    }
    .error_message {
        color: #dc3545;
    }
</style>