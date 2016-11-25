create or replace function upd_issiapsidang() returns "trigger" as
$$
begin
UPDATE mata_kuliah_spesial
SET issiapsidang = true
WHERE (OLD.ijinmajusidang <> NEW.ijinmajusidang AND OLD.pengumpulanhardcopy = true) OR 
	(OLD.pengumpulanhardcopy <> NEW.pengumpulanhardcopy AND OLD.ijinmajusidang = true);
RETURN NEW;
end;
$$
LANGUAGE "plpgsql" VOLATILE;

create trigger upd_issiapsidang
after update
on MATA_KULIAH_SPESIAL
for each row
execute procedure upd_issiapsidang();