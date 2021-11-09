<template>
    <div class="login-container min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-blue-700 bg-opacity-60 overflow-hidden sm:rounded-xl">
            <slot />
        </div>
    </div>
</template>

<style lang="scss">
.login-container {
    background-image: url(/images/loginbackground.png);
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    box-shadow: inset 0 0 0 1000px rgba(0,0,0,.2);
}

</style>