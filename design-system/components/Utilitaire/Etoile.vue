<!-- Composant étoile pour afficher des étoiles -->

<script setup>
    import { defineProps } from 'vue'

    const emit = defineEmits(['delete'])

    const { isMobile } = useDevice()

    const props = defineProps({
    icon: {
        type: String,
        default: ''
    },

    iconSize: {
        type: String,
        default: '16px'
    },

    iconColor: {
        type: String,
        default: ''
    },

    color: {
        type: String,
        default: ''
    },

    starCount: {
        type: Number,
        default: 5
    }
})
</script>

<template>
    <div class="container--image">
        <Icon
            v-for="index in starCount"
            :key="index"
            class="ui-p__icon"
            :name="icon"
            :size="iconSize"
            :color="iconColor || color"
        />
    </div>
</template>

<style scoped>

    .container--image {
        display: flex;
        justify-content: center;
    }

    .ui-p__icon {
        padding: 3px 0;
    }

</style>
