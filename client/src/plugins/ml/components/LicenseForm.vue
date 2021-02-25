<template>
	<validation-observer ref="observer" v-slot="{ invalid }">
		<form @submit.prevent="submit">
			<validation-provider v-slot="{ errors }" name="email" rules="required|email">
				<v-text-field v-model="form.email" :error-messages="errors" label="Email" />
			</validation-provider>

			<validation-provider v-slot="{ errors }" name="password" rules="required">
				<v-text-field v-model="form.password" :error-messages="errors" label="Password" type="password" />
			</validation-provider>

			<v-btn class="mr-4" type="submit" color="primary" :loading="loading" :disabled="submitted && invalid">
				{{ btnText }}
			</v-btn>
		</form>
	</validation-observer>
</template>

<script>
import { required, email } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

extend('required', {
	...required,
	message: '{_field_} is required',
})

extend('email', {
	...email,
	message: 'Email must be valid',
})

export default {
	components: {
		ValidationProvider,
		ValidationObserver,
	},
	props: {
		btnText: {
			type: String,
			default: 'Update',
		},
	},
	data: () => ({
		submitted: false,
		loading: false,
		form: {
			email: '',
			password: '',
		},
	}),

	methods: {
		async submit() {
			this.submitted = true
			const valid = await this.$refs.observer.validate()

			if (!valid) return

			this.loading = true

			this.$app.updateLicense(this.form).then(() => {
				this.loading = false
			})

			// this.$api.post('license', this.form).then(({ data }) => {
			// 	console.log('data', data)
			// })
		},
	},
}
</script>
