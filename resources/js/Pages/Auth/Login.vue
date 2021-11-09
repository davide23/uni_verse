<template>
    <jet-authentication-card class="login-container justify-items-center">

        
        <div class="mb-12 mt-20 flex justify-center">
            <jet-authentication-card-logo />
        </div>

        <jet-validation-errors class="mb-4" />

        <!-- <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div> -->
        <p class="text-white font-bold text-base text-center">Sign in and start managing your candidates!</p>

        <form @submit.prevent="submit" class="px-12 mt-8">
            <div>
                <jet-input id="email" placeholder="Login" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="mt-8">
                <jet-input id="password" placeholder="Password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="flex justify-between mt-6">
                <label class="flex items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-3 text-sm text-white -mb-1">Remember me</span>
                </label>
                <inertia-link v-if="canResetPassword" :href="route('password.request')" class="text-sm -mb-1 text-yellow-400 hover:opacity-90">
                    Forgot password?
                </inertia-link>
            </div>

            <jet-button class="mt-8 mb-16 w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Login
            </jet-button>
        </form>
        <inertia-link href="/" class="absolute bottom-16 ml-16 underline text-center text-white leading-5 font-bold text-base hover:opacity-90">
            Lisa Sorgini  2007, Motherhood series
        </inertia-link>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>


