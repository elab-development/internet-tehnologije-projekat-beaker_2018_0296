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


@app.external(authorize=beaker.Authorize.only(pt.Global.creator_address()))
def opt_into_NFT(NFT: pt.abi.Asset) -> pt.Expr:
    return pt.Seq(
        pt.Assert(app.state.token == pt.Int(0)),
        app.state.token.set(NFT.asset_id()),
        pt.InnerTxnBuilder.Execute(
            {
                pt.TxnField.type_enum: pt.TxnType.AssetTransfer,
                pt.TxnField.asset_receiver: pt.Global.current_application_address(),
                pt.TxnField.xfer_asset: NFT.asset_id(),
                pt.TxnField.asset_amount: pt.Int(0),
                pt.TxnField.fee: pt.Int(0),
            }
        ),
    )


@app.external(authorize=beaker.Authorize.only(pt.Global.creator_address()))
def zapocni_aukciju(
    pocetna_cena: pt.abi.Uint64,
    duzina: pt.abi.Uint64,
    NFTatt: pt.abi.AssetTransferTransaction,
) -> pt.Expr:
    return pt.Seq(
        pt.Assert(app.state.kraj_aukcije == pt.Int(0)),
        app.state.prethodna_ponuda.set(pocetna_cena.get()),
        app.state.kraj_aukcije.set(duzina.get() + pt.Global.latest_timestamp()),
        pt.Assert(
            NFTatt.get().asset_receiver() == pt.Global.current_application_address()
        ),
        app.state.token.set((NFTatt.get().asset_amount())),
        app.state.token_id.set(NFTatt.get().xfer_asset()),
    )


@app.opt_in(bare=True)
def opt_in() -> pt.Expr:
    return app.state.trazeni_iznos[pt.Txn.sender()].set_default()


@app.external
def ponuda(uplata: pt.abi.PaymentTransaction) -> pt.Expr:
    return pt.Seq(
        pt.Assert(app.state.kraj_aukcije.get() > pt.Global.latest_timestamp()),
        pt.Assert(app.state.kraj_aukcije.get() != pt.Int(0)),
        pt.Assert(uplata.get().amount() > app.state.prethodna_ponuda.get()),
        pt.Assert(uplata.get().receiver() == pt.Global.current_application_address()),
        app.state.prethodnji_ponudjac.set(uplata.get().sender()),
        app.state.prethodna_ponuda.set(uplata.get().amount()),
        app.state.trazeni_iznos[pt.Txn.sender()].set(
            app.state.trazeni_iznos[pt.Txn.sender()] + uplata.get().amount()
        ),
    )
