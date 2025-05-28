// Debounce composable for search and input handling
import { ref } from 'vue'

export function useDebounce(fn, delay = 300) {
  const timeoutId = ref(null)

  const debouncedFn = (...args) => {
    if (timeoutId.value) {
      clearTimeout(timeoutId.value)
    }
    
    timeoutId.value = setTimeout(() => {
      fn.apply(null, args)
    }, delay)
  }

  const cancel = () => {
    if (timeoutId.value) {
      clearTimeout(timeoutId.value)
      timeoutId.value = null
    }
  }

  return debouncedFn
}
