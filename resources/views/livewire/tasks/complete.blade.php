<x-modal-confirm
    openEvent="completeTask"
    closeEvent="taskWasUpdated"
    confirmClick="$wire.update"
    title="Complete Task"
    description="Are you sure you want to complete this task?"
/>
