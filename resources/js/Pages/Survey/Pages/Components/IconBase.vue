<template>
  <svg xmlns="http://www.w3.org/2000/svg" 
    :width="width" 
    :height="height" 
    viewBox="0 0 22 22" 
    :aria-labelledby="iconName" 
    role="presentation"
  >
    <g :fill="color">
      <slot />
    </g>
  </svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'box'
    },
    width: {
      type: [Number, String],
      default: 22
    },
    height: {
      type: [Number, String],
      default: 22
    },
    color: {
      type: String,
      default: '#005D30'
    }
  }
}
</script>