<template>
  <div class="q-pa-md q-gutter-md">
    <q-inner-loading :showing="isLoading">
      <q-spinner-gears size="50px" color="primary" />
    </q-inner-loading>
  </div>
</template>

<script setup lang="ts">
import { ILoaderProps } from './Loader.types';

withDefaults(defineProps<ILoaderProps>(), {
  isLoading: false,
});
</script>
