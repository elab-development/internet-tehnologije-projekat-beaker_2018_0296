import beaker
import pyteal as pt
from algokit_utils import DELETABLE_TEMPLATE_NAME, UPDATABLE_TEMPLATE_NAME


class StanjeAukcije:
    pass

    prethodnji_ponudjac = beaker.GlobalStateValue(
        stack_type=pt.TealType.bytes, default=pt.Bytes("")
    )
    prethodna_ponuda = beaker.GlobalStateValue(
        stack_type=pt.TealType.uint64, default=pt.Int(0)
    )
    kraj_aukcije = beaker.GlobalStateValue(
        stack_type=pt.TealType.uint64, default=pt.Int(0)
    )
    token_id = beaker.GlobalStateValue(stack_type=pt.TealType.uint64, default=pt.Int(0))
    trazeni_iznos = beaker.LocalStateValue(
        stack_type=pt.TealType.uint64, default=pt.Int(0)
    )
    token = beaker.GlobalStateValue(stack_type=pt.TealType.uint64, default=pt.Int(0))


app = beaker.Application("aukcija", state=StanjeAukcije)


@app.create(bare=True)
def create() -> pt.Expr:
    return app.initialize_global_state()
