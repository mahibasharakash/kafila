<template>

    <div class="w-full font-semibold flex justify-center items-center flex-col rounded-[0.625rem_0.625rem_0_0] bg-[#f3f3f3] min-h-[calc(100vh-300px)] h-[calc(100vh-300px)] max-h-[calc(100vh-300px)]">
        <div class="mb-2">
            <svg viewBox="0 0 24 24" class="size-[45px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M22 19H14M2 19H10" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M12 17V14" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <circle cx="12" cy="19" r="2" stroke="#3b497e" stroke-width="2"></circle>
                    <path d="M14 14H5C3.34315 14 2 12.6569 2 11C2 9.34315 3.34315 8 5 8H19C20.6569 8 22 9.34315 22 11C22 12.6569 20.6569 14 19 14H18" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M12 2H19C20.6569 2 22 3.34315 22 5C22 6.65685 20.6569 8 19 8H5C3.34315 8 2 6.65685 2 5C2 3.34315 3.34315 2 5 2H8" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M13 5L19 5" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M13 11L19 11" stroke="#3b497e" stroke-width="2" stroke-linecap="round"></path>
                    <circle cx="6" cy="5" r="1" fill="#3b497e"></circle>
                    <circle cx="6" cy="11" r="1" fill="#3b497e"></circle>
                </g>
            </svg>
        </div>
        <div class="mb-2 text-[19px] text-black">
            No Data Found.
        </div>
        <div class="text-[13px] text-black">
            Click to "Add" for new {{ title }} data create
        </div>
    </div>

</template>

<script>

export default {
    props: {
        title: {
            type: String,
            required: true
        }
    },
}

</script>
