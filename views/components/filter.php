<div class="flex justify-center items-center gap-4 rounded-md overflow-hidden">
    <a class="text-gray-400 hover:text-gray-200 hover:underline" href="<?= getUri() ?>">Clear filters</a>
    <form id="filter_tag">
        <select class="bg-white text-gray-400 rounded-md py-2 px-4" name='tag_f' id='tag_f'>
            <option value="">Filter by tag</option>
        </select>
    </form>

    <form id="filter_priority">
        <select class="bg-white text-gray-400 rounded-md py-2 px-4" name='priority_f' id='priority_f'>
            <option value="">Filter by priority</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </form>
</div>