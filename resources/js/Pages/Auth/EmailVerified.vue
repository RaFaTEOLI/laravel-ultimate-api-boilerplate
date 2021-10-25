<template>
    <Head title="Email Verification" />

    <jet-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
            Thanks for verifying your email!
        </div>
    </jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        Link,
    },
});
</script>
