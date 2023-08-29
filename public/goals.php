<select name = "goal" class="form-control" style="text-align:center" required> 
    <option value="" disabled <?= empty($currentGoal) ? 'selected' : ''; ?> > 
         Select from the task/goal</option>
    <option value="Publisher/Future Pioneer" <?= $currentGoal == 'Publisher/Future Pioneer' ? 'selected' : ''; ?> >
        Publisher/Future Pioneer</option>
    <option value="Regular Pioneer (50 hours)" <?= $currentGoal == 'Regular Pioneer (50 hours)' ? 'selected' : ''; ?> >
        Regular Pioneer (50 hours) </option>
    <option value="Auxiliary Pioneer (30 hours)" <?= $currentGoal == 'Auxiliary Pioneer (30 hours)' ? 'selected' : ''; ?> >
        Auxiliary Pioneer (30 hours) </option>
    <option value="Special Pioneer (100 hours)" <?= $currentGoal == 'Special Pioneer (100 hours)' ? 'selected' : ''; ?> >
        Special Pioneer (100 hours) </option>
    <option value="Special Pioneer - Elderly (90 hours)" <?= $currentGoal == 'Special Pioneer - Elderly (90 hours)' ? 'selected' : ''; ?> >
        Special Pioneer - Elderly (90 hours) </option>
</select>