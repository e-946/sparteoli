import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

/**
 * Shared state/behaviour for "click delete -> confirm in a modal -> DELETE request"
 * used by every resource index page instead of window.confirm().
 */
export function useDeleteConfirm() {
    const target = ref(null);
    const processing = ref(false);

    function ask(item) {
        target.value = item;
    }

    function cancel() {
        target.value = null;
    }

    function confirm(routeName, params = {}) {
        if (! target.value) {
            return;
        }

        processing.value = true;

        router.delete(route(routeName, params), {
            preserveScroll: true,
            onFinish: () => {
                processing.value = false;
                target.value = null;
            },
        });
    }

    return { target, processing, ask, cancel, confirm };
}
